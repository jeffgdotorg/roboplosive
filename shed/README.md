# Shed
This directory contains artifacts from fiddling around with the various components of this project:

## [Bruno](https://www.usebruno.com/) collections

### `./openai-api-collection/`
Contains requests that explore the OpenAI Completions API, targeted for use in summarizing article abstracts

#### Example interaction bodies
##### Request
```json
{
  "model": "gpt-4o-mini",
  "messages": [
    {
      "role": "developer",
      "content": "You are a task-specific assistant assigned to generate summaries of scientific paper abstracts and full texts. All summaries must be under 75 words, in a friendly, conversational tone."
    },
    {
      "role": "user",
      "content": "\nSynthesis of antifreeze proteins (AFPs) is one of the adaptations of psychrophilic yeast to live in cold environments. AFPs demonstrate thermal hysteresis (TH) activity and inhibit the recrystallization of ice (IRI) during periodic temperature fluctuations. In this study, the Antarctic yeast strain 186, identified as Glaciozyma martinii, was found to synthesize an extracellular, glycosylated ~27 kDa ice-binding protein (GmAFP) exhibiting IRI activity. It is the first evidence of AFP secretion by the psychrophilic yeast Glaciozyma martinii. To scale up protein production, a synthetic gene from a closely related cold-adapted species, Glaciozyma antarctica, was expressed in Pichia pastoris GS115 strain. The recombinant 26.57 kD protein (GaAFP) displayed IRI activity and a cryoprotective effect in food storage. The addition of GaAFP to the stored frozen vegetables and fruits (carrot, kohlrabi, and blueberry) markedly reduced the drip loss during the thawing process and positively affected their structure, with an effect similar to glycerol. Moreover, GaAFP increased the cell survival of Saccharomyces cerevisiae after freezing. The insights from this study provided proof that AFPs from natural sources may serve as competent biodegradable, eco-friendly, non-cytotoxic and biocompatible substitutes for traditional cryoprotectants in enhancing the quality of frozen foods.\n"
    }
  ]
}
```

##### Response
```json
{
  "id": "chatcmpl-BAz0kaW7VbWP3052Rc8LF4muXHytw",
  "object": "chat.completion",
  "created": 1741957506,
  "model": "gpt-4o-mini-2024-07-18",
  "choices": [
    {
      "index": 0,
      "message": {
        "role": "assistant",
        "content": "This study reveals that the Antarctic yeast Glaciozyma martinii produces an ice-binding protein (GmAFP) which helps it thrive in cold conditions. A synthetic version (GaAFP) was created and expressed in yeast for larger production. GaAFP significantly improved the quality of frozen fruits and vegetables by reducing thaw drip loss, enhancing texture, and boosting yeast cell survival after freezing. This research suggests that natural antifreeze proteins could be eco-friendly alternatives to conventional cryoprotectants in food preservation.",
        "refusal": null,
        "annotations": []
      },
      "logprobs": null,
      "finish_reason": "stop"
    }
  ],
  "usage": {
    "prompt_tokens": 345,
    "completion_tokens": 99,
    "total_tokens": 444,
    "prompt_tokens_details": {
      "cached_tokens": 0,
      "audio_tokens": 0
    },
    "completion_tokens_details": {
      "reasoning_tokens": 0,
      "audio_tokens": 0,
      "accepted_prediction_tokens": 0,
      "rejected_prediction_tokens": 0
    }
  },
  "service_tier": "default",
  "system_fingerprint": "fp_06737a9306"
}
```

### `./plosone-api-collection/`
Contains requests that explore the PLOS search API, used for retrieving article abstracts and metadata

#### Example interaction bodies

##### Request
```sh
curl --request GET \
  --url 'https://api.plos.org/search?q=publication_date%3A%5B2025-03-06T00%3A00%3A00Z%2520TO%25202025-03-13T23%3A59%3A59Z%5D%2520AND%2520journal%3A%2522PLOS%2520ONE%2522&fl=id%2Ctitle%2Cabstract&rows=100&wt=json'
```

##### Response
```json
{
  "response": {
    "numFound": 2591,
    "start": 0,
    "docs": [
      {
        "id": "10.1371/journal.pone.0318459",
        "abstract": [
          "\nSynthesis of antifreeze proteins (AFPs) is one of the adaptations of psychrophilic yeast to live in cold environments. AFPs demonstrate thermal hysteresis (TH) activity and inhibit the recrystallization of ice (IRI) during periodic temperature fluctuations. In this study, the Antarctic yeast strain 186, identified as Glaciozyma martinii, was found to synthesize an extracellular, glycosylated ~27 kDa ice-binding protein (GmAFP) exhibiting IRI activity. It is the first evidence of AFP secretion by the psychrophilic yeast Glaciozyma martinii. To scale up protein production, a synthetic gene from a closely related cold-adapted species, Glaciozyma antarctica, was expressed in Pichia pastoris GS115 strain. The recombinant 26.57 kD protein (GaAFP) displayed IRI activity and a cryoprotective effect in food storage. The addition of GaAFP to the stored frozen vegetables and fruits (carrot, kohlrabi, and blueberry) markedly reduced the drip loss during the thawing process and positively affected their structure, with an effect similar to glycerol. Moreover, GaAFP increased the cell survival of Saccharomyces cerevisiae after freezing. The insights from this study provided proof that AFPs from natural sources may serve as competent biodegradable, eco-friendly, non-cytotoxic and biocompatible substitutes for traditional cryoprotectants in enhancing the quality of frozen foods.\n"
        ],
        "title": "Antifreeze proteins produced by Antarctic yeast from the genus Glaciozyma as cryoprotectants in food storage"
      },
      {
        "id": "10.1371/journal.pone.0318459/title"
      },
      {
        "id": "10.1371/journal.pone.0318459/abstract"
      },
      {
        "id": "10.1371/journal.pone.0318459/references"
      },
      {
        "id": "10.1371/journal.pone.0318459/body"
      },
      {
        "id": "10.1371/journal.pone.0318459/introduction"
      },
      {
        "id": "10.1371/journal.pone.0318459/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0318459/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0318459/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0316373",
        "abstract": [
          "\nBackground\n: Patients with Long COVID (LC) often experience neuropsychiatric symptoms such as depression, anxiety, and chronic fatigue syndrome (CFS), collectively referred to as the physio-affective phenome of LC. Activated immune-inflammatory pathways and insulin resistance significantly contribute to the physio-affective phenome associated with LC. \nMethods\n: In a cohort of 90 individuals, categorized into those with and without LC, we evaluated, 3-6 months following acute SARS-CoV-2 infection, the correlations between the Hamilton Depression (HAMD), Hamilton Anxiety (HAMA), and Fibro-Fatigue (FF) Rating Scale scores, and serum C-reactive protein (CRP), prostaglandin E2 (PGE2), galanin-galanin receptor 1 (GAL-GALR1) signaling, insulin resistance, insulin-like growth factor (IGF-1), plasminogen activator inhibitor-1 (PAI1), S100B and neuron-specific enolase (NSE). \nResults\n: HAMD, HAMA, FF scores, CRP, PGE2, GAL-GALR1 signaling, insulin resistance, PAI1, NSE, and S100B are all higher in people with LC compared to those without LC. The HAMD/HAMA/FF scores were significantly correlated with PGE, CRP, GAL, GALR1, insulin resistance, and PAI1 levels, and a composite score based on peak body temperature (PBT) – oxygen saturation (SpO2) (PBT/SpO2 index) during the acute infectious phase. A combination of biomarkers explained a large part of the variance in CFS and affective scores (33.6%-42.0%), with GAL-GALR1 signaling, PGE2, and CRP being the top 3 most important biomarkers. The inclusion of the PBT/SpO2 index increased the prediction (55.3%-67.1%). The PBT/SpO2 index predicted the increases in GAL-GALR1 signaling. \nConclusion\n: These results indicate that the CFS and affective symptoms that are linked to LC are the consequence of metabolic aberrations, activated immune-inflammatory pathways, and the severity of inflammation during the acute phase of SARS-CoV-2 infection. "
        ],
        "title": "Increased galanin-galanin receptor 1 signaling, inflammation, and insulin resistance are associated with affective symptoms and chronic fatigue syndrome due to long COVID"
      },
      {
        "id": "10.1371/journal.pone.0316373/title"
      },
      {
        "id": "10.1371/journal.pone.0316373/abstract"
      },
      {
        "id": "10.1371/journal.pone.0316373/references"
      },
      {
        "id": "10.1371/journal.pone.0316373/body"
      },
      {
        "id": "10.1371/journal.pone.0316373/introduction"
      },
      {
        "id": "10.1371/journal.pone.0316373/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0316373/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0316373/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0316656",
        "abstract": [
          "\nHappy-productive worker thesis (HPWT) research predicts four configurations depending on well-being and performance levels, one synergistic and three antagonists; however, there has been some discrepancy in the expected results of HPWT, as there are some inclusive results about the specific characteristics that lead to each one of the predicted groups. In this study, we face these discrepancies using a three-configuration model that is more realistic in the organizational context, and exploring how work characteristics, gender, and age can predict workers’ membership in such configurations. We performed multinomial logistic regressions using a sample of 504 Colombian workers and their supervisors from different economic sectors. The results indicated that different work characteristics are associated with the membership of workers in each group, and how this membership varies depending on gender and age group. Our findings offer new research and practice insights about the role of HPWT in HRM (human resources management).\n"
        ],
        "title": "Happy-Productive worker thesis: The role of work characteristics, gender, and age"
      },
      {
        "id": "10.1371/journal.pone.0316656/title"
      },
      {
        "id": "10.1371/journal.pone.0316656/abstract"
      },
      {
        "id": "10.1371/journal.pone.0316656/references"
      },
      {
        "id": "10.1371/journal.pone.0316656/body"
      },
      {
        "id": "10.1371/journal.pone.0316656/introduction"
      },
      {
        "id": "10.1371/journal.pone.0316656/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0316656/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0316656/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0316656/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0316761",
        "abstract": [
          "\nMeiju Oral Liquid (MOL), a representative medicinal formula in China, stems from the traditional use of specific Chinese medicinal herbs known for their anti-fatigue properties, including rose, jujube, chicory, and wolfberry. While these individual herbs have been recognized for their benefits, the formulation of MOL itself has not been extensively studied. This study was designed to evaluate the potential anti-fatigue effects of MOL, prepared from these natural herbs, and to explore its underlying mechanisms. In this research, both mouse and zebrafish models were utilized to investigate the anti-fatigue effects of MOL. Chemical characterization of MOL and identification of bioactive compounds in serum were conducted using ultra-performance liquid chromatography-quadrupole time-of-flight mass spectrometry (UPLC-Q-TOF/MS). The results demonstrated that MOL significantly prolonged the weight-bearing swimming time in mice, increased hepatic and muscle glycogen content, and reduced serum levels of blood urea nitrogen, blood lactate, and inflammatory markers (IL-1β, IL-6, TNF-α, and NO). Furthermore, MOL down-regulated the expression of NOX4 and TNF-α proteins while up-regulating p-PI3K and p-AKT proteins in the liver tissues of fatigued mice. In zebrafish models, MOL exhibited protective effects against sodium sulfite-induced lethality, enhanced high-speed motion trajectories, and increased movement distances in both normal and fatigued zebrafish. Additionally, MOL downregulated IL-1β, IL-6, TNF-α, and TNF-β mRNA levels while up-regulating PI3K and AKT1 mRNA levels in fatigued zebrafish. These findings suggested that the anti-fatigue effects of MOL may be mediated through the activation of the PI3K/AKT signaling pathway as well as the inhibition of TNF-α and NOX4 expression. In addition, a total of ninety-four chemical components were identified in MOL, with twenty-three migration compounds detected in mouse serum. These migration compounds are likely the primary active agents, contributing to the reduction of metabolite accumulation, enhancement of glycogen synthesis, and suppression of inflammatory responses. Taken together, our findings underscore the potential anti-fatigue effects of MOL, warranting further investigation into its therapeutic applications and the specific roles of its bioactive compounds.\n"
        ],
        "title": "Preliminary investigation of anti-fatigue effects and potential mechanisms of meiju oral liquid in mouse and zebrafish models"
      },
      {
        "id": "10.1371/journal.pone.0316761/title"
      },
      {
        "id": "10.1371/journal.pone.0316761/abstract"
      },
      {
        "id": "10.1371/journal.pone.0316761/references"
      },
      {
        "id": "10.1371/journal.pone.0316761/body"
      },
      {
        "id": "10.1371/journal.pone.0316761/introduction"
      },
      {
        "id": "10.1371/journal.pone.0316761/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0316761/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0316761/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0317511",
        "abstract": [
          "\nAge-related macular degeneration (AMD) is a retinal disease prevalent in the elderly population, with two main subtypes: dry (non-exudative) and neovascular (wet or exudative). Neovascular AMD (nAMD) has a more debilitating prognosis than dry AMD, making it the third leading cause of blindness. Intravitreal injections of anti-vascular endothelial growth factor (IV anti-VEGF) are the most effective and widely accepted treatment for nAMD. However, a significant number of nAMD patients exhibit suboptimal responses to IV anti-VEGF therapy, with the underlying mechanisms not yet fully understood. We hypothesized that genetic polymorphisms associated with blood hypercoagulation may also contribute to suboptimal responses to IV anti-VEGF therapy.\nThis study recruited 20 nAMD patients, who were divided into two groups based on their treatment responses after four years: 10 patients with suboptimal responses to IV anti-VEGF therapy and 10 patients with optimal responses. After obtaining institutional ethics board approval, we retrospectively evaluated relevant clinical records of twenty patients diagnosed with nAMD. Patient clinical data were accessed between 20th March 2021 -1st April 2021 for research purposes only. We genotyped peripheral blood DNA from each patient for hypercoagulation-related polymorphisms, including Factor V Leiden (rs6025), prothrombin c.20210G>A (rs1799963), MTHFR A1298C (rs1801131), MTHFR C677T (rs1801133), and SERPINE 1 (PAI-1-675 4G/5G) (rs1799768), and statistically compared the frequencies.\nHeterozygous and homozygous mutations in the SERPINE1 gene specifically PAI-1 promoter region PAI-1-675 4G/5G (rs1799768) were identified as risk factors for resistance to IV anti-VEGF therapy in nAMD patients (χ² test, p = 0.006). No other polymorphisms of the above-mentioned genes were statistically significant (p > 0.05).\nThe failure of IV anti-VEGF therapy in nAMD patients may be influenced by various factors, one of which may be the inherited PAI-1-675 4G/5G (rs1799768) polymorphisms which normally known to contribute hypercoagulation. Further research involving a larger cohort is necessary to uncover the interplay between hereditary factors and other elements contributing to the inefficacy of IV anti-VEGF therapy in nAMD.\n"
        ],
        "title": "Indications of the SERPINE 1 variant rs1799768’s role in anti-VEGF therapy resistance in neovascular age-related macular degeneration"
      },
      {
        "id": "10.1371/journal.pone.0317511/title"
      },
      {
        "id": "10.1371/journal.pone.0317511/abstract"
      },
      {
        "id": "10.1371/journal.pone.0317511/references"
      },
      {
        "id": "10.1371/journal.pone.0317511/body"
      },
      {
        "id": "10.1371/journal.pone.0317511/introduction"
      },
      {
        "id": "10.1371/journal.pone.0317511/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0317511/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0317511/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0316998",
        "abstract": [
          "\nSystemic radionuclide therapy (SRT) using substances such as 177Lu is an approach in cancer treatment that aims to destroy malign tissues by injecting radionuclides directly into patients’ bodies via the bloodstream. This treatment connects benefits of care with risks related to radioactivity. Our research conducted in French hospitals shows that managing risk is an integral part of SRT, spanning from implementation, hospitals’ protocols, specific management, hospital settings, and training, to the individual experiences of health professionals and patients who are both exposed to radioactivity. This article argues that understanding how risks are managed in SRT not only requires making them identifiable, quantifiable, and calculable through medical devices in the context of evidence-based medicine, but also necessitates fostering trust throughout the treatment. This article explores and provides insights into three intertwined dimensions of trust in risk management: epistemic, (inter)-organizational, and interpersonal.\n"
        ],
        "title": "Dealing with radiation risks in systemic cancer treatment: Perspectives of practitioners and patients in French hospitals"
      },
      {
        "id": "10.1371/journal.pone.0316998/title"
      },
      {
        "id": "10.1371/journal.pone.0316998/abstract"
      },
      {
        "id": "10.1371/journal.pone.0316998/references"
      },
      {
        "id": "10.1371/journal.pone.0316998/body"
      },
      {
        "id": "10.1371/journal.pone.0316998/introduction"
      },
      {
        "id": "10.1371/journal.pone.0316998/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0316998/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0316998/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0308431",
        "abstract": [
          "\nSampling methods that are both scientifically rigorous and ethical are cornerstones of any experimental biological research. Since its introduction 30 years ago, the method of using plasticine prey to quantify predation pressure has become increasingly popular in biology. However, recent studies have questioned the accuracy of the method, suggesting that misinterpretation of predator bite marks and the artificiality of the models may bias the results. Yet, bias per se might not be a methodological issue as soon as its statistical distribution in the samples is even, quantifiable, and thus correctable in quantitative analyses. In this study, we focus on avian predation of lepidopteran larvae models, which is one of the most extensively studied predator-prey interactions across diverse ecosystems worldwide. We compared bird predation on plasticine caterpillar models to that on dead caterpillars of similar size and color, using camera traps to assess actual predation events and to evaluate observer accuracy in identifying predation marks a posteriori. The question of whether plasticine models reliably measure insectivorous bird predation remained unanswered, for two reasons: (1) even the evaluation of experienced observers in the posterior assessment of predation marks on plasticine models was subjective to some extent, and (2) camera traps failed to reflect predation rates as assessed by observers, partly because they could only record evidence of bird presence rather than actual predation events. Camera traps detected more evidence of bird presence than predation clues on plasticine models, suggesting that fake prey may underestimate the foraging activity of avian insectivores. The evaluation of avian predation on real caterpillar corpses was probably also compromised by losses to other predators, likely ants. Given the uncertainties and limitations revealed by this study, and in the current absence of more effective monitoring methods, it remains simpler, more cost-effective, ethical, and reliable to keep using plasticine models to assess avian predation. However, it is important to continue developing improved monitoring technologies to better evaluate and refine these methods in order to advance research in this field.\n"
        ],
        "title": "Camera traps unable to determine whether plasticine models of caterpillars reliably measure bird predation"
      },
      {
        "id": "10.1371/journal.pone.0308431/title"
      },
      {
        "id": "10.1371/journal.pone.0308431/abstract"
      },
      {
        "id": "10.1371/journal.pone.0308431/references"
      },
      {
        "id": "10.1371/journal.pone.0308431/body"
      },
      {
        "id": "10.1371/journal.pone.0308431/introduction"
      },
      {
        "id": "10.1371/journal.pone.0308431/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0308431/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0308431/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0308431/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0315641",
        "abstract": [
          "\nA Patient Navigator (PN) role was introduced in the Emergency Department (ED) in a large metropolitan hospital in Southern Ontario (Canada) to assist with care transitions. The purpose of this study was to describe the new PN program and type of services provided for older adults in the ED. Given the novelty of the program, it is critical to better understand how a PN ED model of care may help improve the discharge process and ED-community transitions for older adults. This retrospective observational cohort study includes data between November 2020 and October 2021. In this study, the clinical data collected by the PN were analyzed to describe the patient socio-demographics, types of services provided, and outcomes. The PN contacted 95% patients (n = 125) referred to the service in which the median age was 80 (SD = 9.0) consisting of mostly females (74%; n = 92). The PN provided consultations to 79 patients (≤7 days) and 46 patients were admitted to the PN’s caseload. For the 46 admitted cases, the PN connected to 52% of the patients on the same day, facilitated 83% of the patients in returning home or supportive setting and provided follow-up care (i.e., phone calls or home visits) for 67 days (median) in the community. This study provides a preliminary depiction of the scope of practice of a PN within an ED setting, and important considerations for decision-makers and/or administrators interested in implementing a PN role in the ED.\n"
        ],
        "title": "Implementing a new patient navigator model of care within the emergency department for older adults in Ontario, Canada"
      },
      {
        "id": "10.1371/journal.pone.0315641/title"
      },
      {
        "id": "10.1371/journal.pone.0315641/abstract"
      },
      {
        "id": "10.1371/journal.pone.0315641/references"
      },
      {
        "id": "10.1371/journal.pone.0315641/body"
      },
      {
        "id": "10.1371/journal.pone.0315641/introduction"
      },
      {
        "id": "10.1371/journal.pone.0315641/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0315641/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0315641/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0315641/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0314336",
        "abstract": [
          "\nEosinopenia has been reported as a predictor of unfavorable outcomes and a marker of severity in bacterial infections. We describe the association between eosinopenia and clinical outcomes in hospitalized patients with CAP. We conducted a retrospective study of hospitalized adult patients with community-acquired pneumonia at a large US academic medical center from January 2009 to December 2019. We collected data on patient demographics, disease severity, comorbidities, smoking history, inflammatory markers, blood eosinophil levels, mortality, length of hospital stay, and need for intensive care unit (ICU) or mechanical ventilation. According to blood eosinophil count, patients were grouped as eosinopenic (<50/μL) and non-eosinopenic (≥50/μL) based on prior studies. Analysis was performed using nonparametric Wilcoxon rank-sum test for continuous variables and the chi-square test for categorical variables. A logistic regression analysis with robust standard errors was used to assess the associations between eosinopenia and patient centered outcomes (in-hospital mortality, 30-day mortality, length of hospital stay, need for mechanical ventilation support, vasopressor support and ICU admission). Of the 3285 patients with CAP infection included in our analysis, 1304 (39.70%) were eosinopenic. Age, gender, race, and smoking status were similar between the two groups. The eosinopenic group had significantly higher inflammatory markers as measured by C-reactive protein (CRP), and higher disease severity scores., After adjusting for disease severity, chronic obstructive pulmonary (COPD), and CRP there was no significant difference in hospital mortality (odds ratio [OR] 2.16, 95% confidence interval [CI] 0.68-6.8), ICU admission (OR: 1.21, 95% CI: 0.83-1.79), invasive and non-invasive ventilatory support (OR: 1.21, 95% CI: 0.52-2.81). Contrary to previously published data, our analysis did not demonstrate an association between eosinopenia and increased mortality risk in hospitalized patients with CAP highlighting the complexity of CAP prognosis.\n"
        ],
        "title": "Eosinopenia as a predictor of clinical outcomes in hospitalized patients with community-acquired pneumonia: A retrospective cohort study"
      },
      {
        "id": "10.1371/journal.pone.0314336/title"
      },
      {
        "id": "10.1371/journal.pone.0314336/abstract"
      },
      {
        "id": "10.1371/journal.pone.0314336/references"
      },
      {
        "id": "10.1371/journal.pone.0314336/body"
      },
      {
        "id": "10.1371/journal.pone.0314336/introduction"
      },
      {
        "id": "10.1371/journal.pone.0314336/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0314336/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0314336/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0314336/conclusions"
      },
      {
        "id": "10.1371/journal.pone.0312205",
        "abstract": [
          "\nTo generate a novel oncolytic vaccinia virus with improved safety and productivity, the genome of smallpox vaccine strain LC16m8 was modified by a bacterial artificial chromosome system. By using LC16m8, a replicating virus homologous to the target virus, as a helper virus for the bacterial artificial chromosome system, we successfully recovered genome-edited infectious viruses. Oncolytic viruses with limited growth in normal cells were obtained by deleting the genes for vaccinia virus growth factor (VGF), extracellular signal-regulated kinase-activating protein (O1L), and ribonucleotide reductase (RNR) present in the viral genome. Furthermore, the amino acid residues of seven proteins involved in extracellular enveloped virus virion formation were replaced to the IHD-J strain sequence, which is known to highly express extracellular enveloped virus. In cultured cancer cells (HeLa), these modified viruses showed cytotoxicity and increased productivity, but it was confirmed that the cytotoxicity was suppressed in normal cells (normal human dermal fibroblasts). For in vivo safety evaluation, a modified virus (MD-RVV-ΔRR-EEV6) in which the VGF, O1L, and RNR genes of LC16m8 were deleted and the genes of six extracellular enveloped virus-associated proteins were replaced with sequences derived from IHD-J strain, and another modified virus (MD-RVV) lacking only the VGF and O1L were administered intravenously to severe combined immunodeficiency mice. In the MD-RVV administration, animals in all dose groups died by 40 days after virus administration. On the other hand, after MD-RVV-ΔRR-EEV6 administration, 3 out of 5 animals in the high and medium dose groups and all animals in the low dose group were still alive by day 71, the end of the observation period. These results demonstrate that genome editing of oncolytic vaccinia virus can delete genes involved in viral replication to improve safety in normal cells, while replacing genes involved in maturation improves proliferative potential in cancer cells.\n"
        ],
        "title": "A novel oncolytic vaccinia virus with multiple gene modifications involved in viral replication and maturation increases safety for intravenous administration while maintaining proliferative potential in cancer cells"
      },
      {
        "id": "10.1371/journal.pone.0312205/title"
      },
      {
        "id": "10.1371/journal.pone.0312205/abstract"
      },
      {
        "id": "10.1371/journal.pone.0312205/references"
      },
      {
        "id": "10.1371/journal.pone.0312205/body"
      },
      {
        "id": "10.1371/journal.pone.0312205/introduction"
      },
      {
        "id": "10.1371/journal.pone.0312205/results_and_discussion"
      },
      {
        "id": "10.1371/journal.pone.0312205/materials_and_methods"
      },
      {
        "id": "10.1371/journal.pone.0315313",
        "abstract": [
          "Background: The prevalence of mental disorders among children and youth has significantly increased, with rising rates of anxiety, depression, and other psychological disorders globally. Despite the widespread adoption of cognitive behavioral therapy (CBT) as a standardized treatment for various mental disorders, its efficacy can be constrained due to limited patient engagement, lack of commitment, and stigma, all challenges pronounced among children and youth. In this context, extended reality (XR) technologies (including virtual, augmented, and mixed reality) have emerged as innovative therapeutic tools offering immersive and engaging environments to overcome the limitations of traditional CBT. Objectives: This protocol aims to outline the methodology for conducting a systematic review and meta-analysis to evaluate the impact of XR-CBT on symptoms of mental disorders among children and youth. Methods: This systematic review and meta-analysis will follow PRISMA-P 2015 guidelines. A comprehensive search will be conducted in PsycINFO, PubMed, EMBASE, Scopus, and Web of Science to identify relevant studies published between January 2014 and June 2024. Eligible studies must involve children and youth (ages 24 years or younger) diagnosed with a mental disorder (e.g., anxiety, depression, ADHD, PTSD) and compare XR-CBT interventions (virtual, augmented, or mixed reality) with traditional therapy or control groups (e.g., no treatment). The primary outcome will be the change in symptoms of mental disorders, measured using standardized instruments (e.g., PHQ-9, GAD-7, PSS). Data will be extracted on post-intervention means, standard deviations, and 95% confidence intervals. Effect sizes, calculated using Hedges’ g, will be pooled with a random-effects model. Moreover, an a priori meta-regression within a random-effects framework will be conducted to examine how study-level characteristics influence effect sizes and address heterogeneity across studies. Heterogeneity will be assessed using the I2 statistic and the Cochran’s Q test. Risk of bias in individual studies will be evaluated using the Cochrane risk-of-bias tool. Conclusions: This protocol establishes a structured approach for assessing the efficacy of XR-CBT interventions on mental disorders among children and youth. The results of the systematic review and meta-analysis will fill a gap in current research and inform future therapeutic applications for mental health interventions among children and youth. "
        ],
        "title": "The impact of extended reality cognitive behavioral therapy on mental disorders among children and youth: A systematic review and meta-analysis protocol"
      },
      {
        "id": "10.1371/journal.pone.0315313/title"
      },
      {
        "id": "10.1371/journal.pone.0315313/abstract"
      },
      {
        "id": "10.1371/journal.pone.0315313/references"
      },
      {
        "id": "10.1371/journal.pone.0315313/body"
      },
      {
        "id": "10.1371/journal.pone.0315313/supporting_information"
      },
      {
        "id": "10.1371/journal.pone.0316287",
        "abstract": [
          "\nThe accurate prediction and interpretation of corporate Environmental, Social, and Governance (ESG) greenwashing behavior is crucial for enhancing information transparency and improving regulatory effectiveness. This paper addresses the limitations in hyperparameter optimization and interpretability of existing prediction models by introducing an optimized machine learning framework. The framework integrates an Improved Hunter-Prey Optimization (IHPO) algorithm, an eXtreme Gradient Boosting (XGBoost) model, and SHapley Additive exPlanations (SHAP) theory to predict and interpret corporate ESG greenwashing behavior. Initially, a comprehensive ESG greenwashing prediction dataset was developed through an extensive literature review and expert interviews. The IHPO algorithm was then employed to optimize the hyperparameters of the XGBoost model, forming an IHPO-XGBoost ensemble learning model for predicting corporate ESG greenwashing behavior. Finally, SHAP was used to interpret the model’s prediction outcomes. The results demonstrate that the IHPO-XGBoost model achieves outstanding performance in predicting corporate ESG greenwashing, with R², RMSE, MAE, and adjusted R² values of 0.9790, 0.1376, 0.1000, and 0.9785, respectively. Compared to traditional HPO-XGBoost models and XGBoost models combined with other optimization algorithms, the IHPO-XGBoost model exhibits superior overall performance. The interpretability analysis using SHAP theory highlights the key features influencing the prediction outcomes, revealing the specific contributions of feature interactions and the impacts of individual sample features. The findings provide valuable insights for regulators and investors to more effectively identify and assess potential corporate ESG greenwashing behavior, thereby enhancing regulatory efficiency and investment decision-making.\n"
        ],
        "title": "An optimized machine learning framework for predicting and interpreting corporate ESG greenwashing behavior"
      }
    ]
  }
}
```
