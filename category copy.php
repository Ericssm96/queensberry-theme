<?php
$page_product_group = "Férias na Neve";

get_header();

$category = get_queried_object();
$category_name = $category->name;

function get_active_programs() {
    $url = "https://gx.befly.com.br/bsi/rest/wsProgramasAtivos";

    $programs_req_payload = [
        "Token" => "e9cf3b5a-9408-472f-8dd3-b5f36ff75698"
    ];

    $req_headers = [
        "Content-Type: application/json"
    ];

    $curl_programs_request = curl_init();

    curl_setopt($curl_programs_request, CURLOPT_URL, $url);
    curl_setopt($curl_programs_request, CURLOPT_POST, true);
    curl_setopt($curl_programs_request, CURLOPT_POSTFIELDS, json_encode($programs_req_payload));
    curl_setopt($curl_programs_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_programs_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_programs_request);
    $response = json_decode($response_json, true);

    curl_close($curl_programs_request);

    return $response;
}

$active_programs_response = get_active_programs();
$active_programs = $active_programs_response["ProgramasAtivosPortal"]["ProgramasAtivoPortal"];

function is_item_in_current_product_group($product) {
    return $product["CategoriaDescricao"] === strtoupper($page_product_group);
}

$products_snow_holidays = array_filter($active_programs, 'is_item_in_current_product_group');

?>

   <?php
    foreach($active_programs as $active_program) {
    ?>
        <ul>
        <?php
        foreach($active_program as $program_item){
        ?>
        <p><?= $program_item ?></p>
        <?php
        }
        ?>
        </ul>
        -------
        <?php
    }
   ?>


<?php get_footer(); ?>