<?php
// Tee up the date range Solr query parameter for passing to the PLOS API
$now = time();
$week_ago = time() - (60 * 60 * 24 * 7);
$week_ago_text = strftime("%Y-%m-%dT00:00:00Z", $week_ago);
$now_text = strftime("%Y-%m-%dT00:00:00Z", $now);
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
    echo "No documents found in PLOS API response";
}
if (empty($usable_plos_docs)) {
    $total_docs = count($plos_api_data['response']['docs']);
    echo "Error: No usable articles found among the {$total_docs} in PLOS API response";
    exit;
}


?>