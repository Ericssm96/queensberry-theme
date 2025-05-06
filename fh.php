<?php

add_action('admin_post_bft_newsletter', 'bft_handle_newsletter_sign_up');
add_action('admin_post_nopriv_bft_newsletter', 'bft_handle_newsletter_sign_up');

function get_API_credentials() {
    $url = "https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/auth/token";


    $api_credentials_request_payload = [
        "user_name" => "user-api-befly",
        "password" => "YOT0eTCj&Y",
        "auth_type" => "password"
    ];

    $req_headers = [
        "Content-Type: application/x-www-form-urlencoded"
    ];

    $curl_key_request = curl_init();

    curl_setopt($curl_key_request, CURLOPT_URL, $url);
    curl_setopt($curl_key_request, CURLOPT_POST, true);
    curl_setopt($curl_key_request, CURLOPT_POSTFIELDS, http_build_query($api_credentials_request_payload));
    curl_setopt($curl_key_request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_key_request, CURLOPT_HTTPHEADER, $req_headers);

    $response_json = curl_exec($curl_key_request);
    $response = json_decode($response_json, true);

    curl_close($curl_key_request);

    return $response;
}

function bft_sign_up_responsys($sign_up_payload, $key, $url) {
    $req_headers = [
        "Content-Type: application/json",
        "Authorization: $key"
    ];

    $curl_user_sign_up = curl_init();

    curl_setopt($curl_user_sign_up, CURLOPT_URL, $url);
    curl_setopt($curl_user_sign_up, CURLOPT_POST, true);
    curl_setopt($curl_user_sign_up, CURLOPT_POSTFIELDS, json_encode($sign_up_payload));
    curl_setopt($curl_user_sign_up, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_user_sign_up, CURLOPT_HTTPHEADER, $req_headers);

    $sign_up_response_json = curl_exec($curl_user_sign_up);
    $sign_up_response = json_decode($sign_up_response_json, true);
    $sign_up_status = curl_getinfo($curl_user_sign_up, CURLINFO_HTTP_CODE);

    curl_close($curl_user_sign_up);

    return [
        "status" => $sign_up_status,
        "response" => $sign_up_response
    ];
}

function bft_responsys_profile_extension($sign_up_payload, $key, $url) {
    $req_headers = [
        "Content-Type: application/json",
        "Authorization: $key"
    ];

    $curl_user_profile_extension = curl_init();

    curl_setopt($curl_user_profile_extension, CURLOPT_URL, $url);
    curl_setopt($curl_user_profile_extension, CURLOPT_POST, true);
    curl_setopt($curl_user_profile_extension, CURLOPT_POSTFIELDS, json_encode($sign_up_payload));
    curl_setopt($curl_user_profile_extension, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_user_profile_extension, CURLOPT_HTTPHEADER, $req_headers);

    $profile_ext_response_json = curl_exec($curl_user_profile_extension);
    $profile_ext_response = json_decode($profile_ext_response_json, true);
    $profile_ext_status = curl_getinfo($curl_user_profile_extension, CURLINFO_HTTP_CODE);

    curl_close($curl_user_profile_extension);

    return [
        "status" => $profile_ext_status,
        "response" => $profile_ext_response
    ];
}

function bft_responsys_supplemental_table($sign_up_payload, $key, $url) {
    $req_headers = [
        "Content-Type: application/json",
        "Authorization: $key"
    ];

    $curl_user_supplemental_register = curl_init();

    curl_setopt($curl_user_supplemental_register, CURLOPT_URL, $url);
    curl_setopt($curl_user_supplemental_register, CURLOPT_POST, true);
    curl_setopt($curl_user_supplemental_register, CURLOPT_POSTFIELDS, json_encode($sign_up_payload));
    curl_setopt($curl_user_supplemental_register, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_user_supplemental_register, CURLOPT_HTTPHEADER, $req_headers);

    $supplemental_register_response_json = curl_exec($curl_user_supplemental_register);
    $supplemental_register_response = json_decode($supplemental_register_response_json, true);
    $supplemental_register_status = curl_getinfo($curl_user_supplemental_register, CURLINFO_HTTP_CODE);

    curl_close($curl_user_supplemental_register);

    return [
        "status" => $supplemental_register_status,
        "response" => $supplemental_register_response
    ];
}

function bft_handle_newsletter_sign_up() {

    $user_email = $_POST["EMAIL_ADDRESS_"];
    $user_name = $_POST["NOME_COMPLETO"];
    $user_phone_number = $_POST["FULL_PHONE_NUMBER"];
    $privacy_policy_agreement = $_POST["PRIVACY_POLICY"];
    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];
    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];
    $cel_opt_in = $_POST["MOBILE_PERMISSION_STATUS_"];
    $newsletter_novidades = $_POST["NEWSLETTER_NOVIDADES"];

    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    $sign_up_payload = [
        "recordData"=> [
            "fieldNames" => [
                "FIRST_NAME",
                "MOBILE_NUMBER_",
                "EMAIL_ADDRESS_",
                "EMAIL_PERMISSION_STATUS_",
                "MOBILE_PERMISSION_STATUS_"
            ],
            "records"=> [
                [
                    $user_name,
                    $user_phone_number,
                    $user_email,
                    $email_opt_in,
                    $cel_opt_in
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule"=> [
            "htmlValue"=> "H",
            "optinValue"=> "I",
            "textValue"=> "T",
            "insertOnNoMatch"=> true,
            "updateOnMatch"=> "REPLACEALL",
            "matchColumnName1"=> "EMAIL_ADDRESS_",
            "matchColumnName2"=> null,
            "matchOperator"=> "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];

    $profile_ext_payload = [
        "recordData"=> [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "NEWSLETTER_NOVIDADES"
            ],
            "records"=> [
                [
                    $user_email,
                    "Befly Newsletter Novidades"
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch"=> true,
        "updateOnMatch"=> "REPLACE_ALL",
        "matchColumnName1"=> "EMAIL_ADDRESS",
    ];


    $supplemental_register_payload = [
        "recordData"=> [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records"=> [
                [
                    $user_email,
                    "Befly Newsletter Novidades",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch"=> true,
        "updateOnMatch"=> "REPLACE_ALL",

    ];



    $count = 0;

    while($count < 3) {
        $sign_up_result = bft_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_BeFly_Travel/members');


        if($sign_up_result["status"] == 200) {
            $profile_ext_result = bft_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_BeFly_Travel/listExtensions/PET_ORIGENS_CADASTROS_BEFLY_TRAVEL/members');

            if($profile_ext_result["status"] == 200) {
                $supplemental_register_result = bft_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_BEFLY_TRAVEL/members');

                if($supplemental_register_result["status"] == 200) {
                    /* wp_send_json_success([
                        "message" => "Cadastro concluído com sucesso!",
                    ]); */
                    header('Location: https://beflytravel.com.br/obrigado/');
                    return;
                }
            }
        }

        $count += 1;

        $api_credentials = get_API_credentials();
        $api_key = $api_credentials["authToken"];
    }

    wp_send_json_error([
        "message" => "O servidor está offline no momento, por favor, tente novamente mais tarde",
    ]);
    return;

}

function bft_handle_stores_sign_up($data = []) {

    $data = $_POST;
    $user_email = $data["user_email"];
    $user_name = $data["user_name"];
    $user_phone_number = $data["full_phone_number"];
    $store_name = $data["store_name"];
    $message = $data["message"];
    $current_date = date("Y-m-d");

    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    $sign_up_payload = [
        "recordData"=> [
            "fieldNames" => [
                "FIRST_NAME",
                "MOBILE_NUMBER_",
                "EMAIL_ADDRESS_"
            ],
            "records"=> [
                [
                    $user_name,
                    $user_phone_number,
                    $user_email
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule"=> [
            "htmlValue"=> "H",
            "optinValue"=> "I",
            "textValue"=> "T",
            "insertOnNoMatch"=> true,
            "updateOnMatch"=> "REPLACEALL",
            "matchColumnName1"=> "EMAIL_ADDRESS_",
            "matchColumnName2"=> null,
            "matchOperator"=> "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];

    $profile_ext_payload = [
        "recordData"=> [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "LOJA",
                "MENSAGEM",
                "DATA_CADASTRO"
            ],
            "records"=> [
                [
                    $user_email,
                    $store_name,
                    $message,
                    $current_date
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch"=> true,
        "updateOnMatch"=> "REPLACE_ALL",
        "matchColumnName1"=> "EMAIL_ADDRESS",
    ];


    $count = 0;

    while($count < 3) {
        $sign_up_result = bft_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_BeFly_Travel/members');


        if($sign_up_result["status"] == 200) {
            $profile_ext_result = bft_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_BeFly_Travel/listExtensions/PET_FALE_CONOSCO_BEFLY_TRAVEL/members');

            if($profile_ext_result["status"] == 200) {
                mail_bft_lojas_data($data);

                return;
            }
        }

        $count += 1;

        $api_credentials = get_API_credentials();
        $api_key = $api_credentials["authToken"];
    }

    wp_send_json_error([
        "message" => "O servidor está offline no momento, por favor, tente novamente mais tarde",
        "dados" => $data,
        "data" => $current_date
    ]);
    return;

}

function mail_bft_lojas_data($data) {

    /*$data = $_POST;

    $user_name = filter_input(INPUT_POST, "USER_NAME", FILTER_SANITIZE_SPECIAL_CHARS);
    $user_email = filter_input(INPUT_POST, "USER_EMAIL", FILTER_SANITIZE_EMAIL);
    $store_email = filter_input(INPUT_POST, "STORE_EMAIL", FILTER_SANITIZE_EMAIL);
    $user_phone = filter_input(INPUT_POST, "USER_PHONE", FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, "MESSAGE", FILTER_SANITIZE_SPECIAL_CHARS);*/
    $user_name = $data["user_name"];
    $user_email = $data["user_email"];
    $store_email = $data["store_email"];
    $user_phone = $data["user_phone"];
    $user_ddd = $data["user_ddd"];
    $message = $data["message"];
    $full_phone = "$user_ddd $user_phone";

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP_DEBUG;
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = SMTP_AUTH;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom('naoresponda@flytour.com.br', 'Flytour');
        $mail->addAddress($store_email);
        $mail->addBCC('ericssm96@gmail.com');
        // $mail->addBCC('trademkt@flytour.com.br', 'Flytour Trade Marketing');

        $mail->isHTML(true);
        $mail->Subject = 'Formulário Befly Travel - Lojas';
        $mail->Body    =
            <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Formulário - Befly Travel Lojas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <div style="font-family: Arial; display: block; width: 100%;">
      <p style="text-align: justify; font-size: 1.1rem; ; margin: 0 auto; padding: 20px; max-width: 600px;">Um novo cadastro foi realizado através do formulário "Befly Travel Lojas". Segue detalhes do cadastro:</p>
      <div style="width: 100%; max-width: 600px; margin: 0 auto;">
        <h1 style="font-size: 1.1rem">Informações Básicas</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Nome do usuário:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$user_name</td>
          </tr>
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Email para contato:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$user_email</td>
          </tr>
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Celular para contato:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$full_phone</td>
          </tr>
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Mensagem:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$message</td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
HTML;

        $mail->CharSet = "UTF-8";
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';

        foreach ($_FILES as $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }
        }

        $mail->send();

        header("Location: https://beflytravel.com.br/obrigado/");


    } catch (Exception $e) {
        wp_send_json_error([
            'message' => 'Email não enviado',
            'dadps' => $data
        ]);

        return;
    }
}

/*add_action('admin_post_test_form_bft_lojas', 'bft_handle_stores_sign_up');
add_action('admin_post_nopriv_test_form_bft_lojas', 'bft_handle_stores_sign_up');*/
add_action('admin_post_form_bft_lojas', 'bft_handle_stores_sign_up');
add_action('admin_post_nopriv_form_bft_lojas', 'bft_handle_stores_sign_up');

function verify_recaptcha() {
    $form_data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if(isset($form_data)) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=6Lc7NYEpAAAAAIUztv8psSoulpfWmNMh8YsRYZi5&response=" . $form_data["recaptcha_response_token"]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close($curl);

        $response_data =  json_decode($response, true);

        if($response_data["success"] == true) {
            bft_handle_stores_sign_up($form_data);
            // mail_bft_lojas_data($form_data);
        } else {
            wp_send_json_error([
                'message' => 'Email não enviado',
                'response_data' => $response_data
            ]);
        }
    }
}


function mail_test_bft_lojas_data($data) {
    /*$data = $_POST;

       $user_name = filter_input(INPUT_POST, "USER_NAME", FILTER_SANITIZE_SPECIAL_CHARS);
       $user_email = filter_input(INPUT_POST, "USER_EMAIL", FILTER_SANITIZE_EMAIL);
       $store_email = filter_input(INPUT_POST, "STORE_EMAIL", FILTER_SANITIZE_EMAIL);
       $user_phone = filter_input(INPUT_POST, "USER_PHONE", FILTER_SANITIZE_SPECIAL_CHARS);
       $message = filter_input(INPUT_POST, "MESSAGE", FILTER_SANITIZE_SPECIAL_CHARS);*/
    $user_name = $data["USER_NAME"];
    $user_email = $data["USER_EMAIL"];
    $store_email = $data["STORE_EMAIL"];
    $user_phone = $data["USER_PHONE"];
    $message = $data["MESSAGE"];

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP_DEBUG;
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = SMTP_AUTH;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom('naoresponda@flytour.com.br', 'Flytour');
        $mail->addAddress('ericssm96@gmail.com');
        // $mail->addBCC('ericssm96@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Formulário Befly Travel - Lojas';
        $mail->Body    =
            <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Formulário - Befly Travel Lojas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
    <div style="font-family: Arial; display: block; width: 100%;">
      <p style="text-align: justify; font-size: 1.1rem; ; margin: 0 auto; padding: 20px; max-width: 600px;">Um novo cadastro foi realizado através do formulário "Befly Travel Lojas". Segue detalhes do cadastro:</p>
      <div style="width: 100%; max-width: 600px; margin: 0 auto;">
        <h1 style="font-size: 1.1rem">Informações Básicas</h1>
        <table style="width: 100%;">
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Nome do usuário:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$user_name</td>
          </tr>
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Email para contato:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$user_email</td>
          </tr>
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Celular para contato:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$user_phone</td>
          </tr>
          <tr>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Mensagem:</td>
            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$message</td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
HTML;

        $mail->CharSet = "UTF-8";
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';

        foreach ($_FILES as $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }
        }

        $mail->send();

        header("Location: https://beflytravel.com.br/obrigado/");


    } catch (Exception $e) {
        wp_send_json_error([
            'message' => 'Email não enviado',
            'dados' => $data
        ]);

        return;
    }
}

