<?php
// Pull in the AWS SDK from the PHAR distribution
require 'lib/aws.phar';

// Initialize an AWS PollyClient for generative TTS
$pollyClient = new Aws\Polly\PollyClient([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'credentials' => [
        'key' => getenv('AWS_ACCESS_KEY'),
        'secret' => getenv('AWS_ACCESS_KEY')
    ]
]);

/**
 * Summarize the abstract using OpenAI API.
 *
 * @param string $abstract The abstract text to summarize.
 * @param string $api_key  The OpenAI API key.
 * @return string The summary of the abstract.
 */
function summarize_abstract_openai($abstract, $api_key) {
    $url = "https://api.openai.com/v1/chat/completions";
    $model = "gpt-4o-mini";
    $dev_prompt = "You are a task-specific assistant assigned to generate summaries of scientific paper abstracts and full texts. All summaries must be under 75 words, in a friendly, conversational tone.";

    $data = [
        'model' => $model,
        'messages' => [
            [
                'role' => 'developer',
                'content' => $dev_prompt
            ],
            [
                'role' => 'user',
                'content' => $abstract
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute the OpenAI API curl operation and get the response
    $response = curl_exec($ch);

    // Check for errors
    if (curl_error($ch)) {
        echo 'cURL error: ' . curl_error($ch) . "\n";
        curl_close($ch);
        return false;
    }
    // Close the cURL session
    curl_close($ch);

    // Decode the response and extract the summary
    $response_data = json_decode($response, true);
    if (isset($response_data['choices'][0]['message']['content'])) {
        return trim($response_data['choices'][0]['message']['content']);
    }
    echo "Error: OpenAI response lacks choices[0].message.content\n";
    return false;
}

/**
 * Generate an MP3 file from text using AWS Polly.
 *
 * @param string $text The text to convert to speech.
 * @param int $voice_idx A index (0-based) into an array of preselected voice IDs.
 * @param string $output_file The output file path for the MP3.
 * @return bool True if the file was successfully created, false otherwise.
 */
function tts_segment_polly($text, $voice_idx, $output_file) {
    global $pollyClient;  // Initialized outside the function

    $voices[] = [ 'Stephen', 'Danielle' ];
    if ($voice_idx > count($voices) - 1) $voice_idx = 0;

    try {
        $result = $pollyClient->synthesizeSpeech([
            'Text' => $text,
            'OutputFormat' => 'mp3',
            'Engine' => 'generative',
            'VoiceId' => $voices[$voice_idx],
            'TextType' => 'text'
        ]);

        // Get the audio stream from the result
        $audio_stream = $result->get('AudioStream');

        // Save the audio stream as an MP3 file
        file_put_contents($output_file, $audio_stream);
        return true;
    } catch (Aws\Exception\AwsException $e) {
        echo "Error generating speech: " . $e->getMessage() . "\n";
        return false;
    }
}

/**
 * Generate the episode intro text
 *
 * @param array $docs Usable PLOS articles for this episode
 * @return string Text of episode intro, ready for TTS
 */
function make_intro_text($docs) {
    $article_count = count($docs);
    return "
    Welcome to Roboplosive, the daily science podcast that summarizes recently
    published papers from the scientific literature.
    
    In this episode we cover {$article_count} publications from the journal PLOS ONE.
    Data Provided by PLOS.
    ";
}

/**
 * Generate a segment's text
 *
 * @param array $doc The PLOS article covered in this segment
 * @param string $summary The summarized abstract for this article
 * @return string The segment text, ready for TTS
 */
function make_segment_text($doc, $summary) {
    $segment_title = $doc['title'];
    $author_lead = $doc['author_lead'];
    $author_count = $doc['author_count'];
    $segment_body = summarize_abstract_openai($doc['abstract'], getenv('OPENAI_API_KEY'));
    return "
    {$segment_title}
    
    Lead author {$author_lead}. This paper has {$author_count} authors.
    
    {$segment_body}
    ";
}

/**
 * Queries the PLOS API for publications in the past week, returning an
 * array of results that have primary abstracts. Each entry in the list
 * has the following keys:
 *
 * id: The article's ID (its DOI)
 * title: The article's title
 * author_lead: The article lead author's name
 * author_count: The total number of authors on the article
 * abstract: The article's primary abstract
 * publication_date: The article's publication date
 *
 * @return array An array of usable PLOS article results
 * @throws DateMalformedStringException
 */
function get_plos_docs()
{
// Tee up the date range Solr query parameter for passing to the PLOS API
    $now = new DateTime();
    $now->setTime(0, 0, 0);
    $week_ago = (new DateTime())->modify('-1 week');
    $week_ago->setTime(0, 0, 0);
    $week_ago_text = $week_ago->format('Y-m-d\TH:i:s\Z');
    $now_text = $now->format('Y-m-d\TH:i:s\Z');
    $pub_date_range = "[{$week_ago_text} TO {$now_text}]";

// Build the PLOS API URL
    $plos_api_url = "https://api.plos.org/search";
    $plos_api_query = http_build_query(array(
        "q" => "publication_date:{$pub_date_range} AND journal:\"PLOS ONE\"",
        "fl" => "id,title,author_display,abstract_primary_display,publication_date",
        "rows" => 100,
        "wt" => "json"
    ));
    $plos_api_url_with_query = $plos_api_url . "?" . $plos_api_query;

// Build the curl worker for querying the PLOS API
    $ch = curl_init($plos_api_url_with_query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Execute the PLOS API curl operation and validate its success
    $plos_api_result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL error querying PLOS API: ' . curl_error($ch);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

// Decode the JSON document returned from the PLOS API
    $plos_api_data = json_decode($plos_api_result, true);
    if ($plos_api_data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error parsing JSON from PLOS API: " . json_last_error_msg();
        exit;
    }

// Normalize the resulting data structure for the PLOS API data,
// omitting any results that lack an abstract
    if (isset($plos_api_data['response']) && isset($plos_api_data['response']['docs'])) {
        $plos_docs = $plos_api_data['response']['docs'];
        foreach ($plos_docs as $plos_doc) {
            if (!empty($plos_doc['abstract_primary_display'])) {
                $usable_plos_docs[] = [
                    'id' => $plos_doc['id'],
                    'title' => $plos_doc['title'],
                    'author_lead' => $plos_doc['author_display'][0],
                    'author_count' => count($plos_doc['author_display']),
                    'abstract' => $plos_doc['abstract_primary_display'][0],
                    'publication_date' => $plos_doc['publication_date']
                ];
            }
        }
    } else {
        echo "No documents found in PLOS API response\n";
        return [];
    }
    if (empty($usable_plos_docs)) {
        $total_docs = count($plos_api_data['response']['docs']);
        echo "Error: No usable articles found among the {$total_docs} in PLOS API response\n";
        return [];
    }
    return $usable_plos_docs;
}

// Main execution starts here
$episode_docs = get_plos_docs();
