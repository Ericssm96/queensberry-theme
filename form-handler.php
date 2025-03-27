<?php
require_once get_template_directory() . '/../../../vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

//hooks
// hook que vem do form Fale Conosco
add_action('admin_post_queensberry_fale_conosco', 'queensberry_handle_fale_conosco_sign_up');
add_action('admin_post_nopriv_queensberry_fale_conosco', 'queensberry_handle_fale_conosco_sign_up');

// hook que vem do form Popup Cadastro
add_action('admin_post_queensberry_popup_cadastro', 'queensberry_handle_popup_cadastro');
add_action('admin_post_nopriv_queensberry_popup_cadastro', 'queensberry_handle_popup_cadastro');

// hook que vem do form Newsletter Receba Novidades
add_action('admin_post_queensberry_receba_novidades', 'queensberry_handle_receba_novidades');
add_action('admin_post_nopriv_queensberry_receba_novidades', 'queensberry_handle_receba_novidades');

// hook que vem do form Programa
add_action('admin_post_queensberry_programa', 'queensberry_handle_programa');
add_action('admin_post_nopriv_queensberry_programa', 'queensberry_handle_programa');

// hook que vem do form Recomendar Programa
add_action('admin_post_queensberry_recomendar_programa', 'queensberry_handle_recomendar_programa');
add_action('admin_post_nopriv_queensberry_recomendar_programa', 'queensberry_handle_recomendar_programa');

// hook que vem do form Queensclub Cadastro
add_action('admin_post_queensberry_queensclub', 'queensberry_handle_queensclub');
add_action('admin_post_nopriv_queensberry_queensclub', 'queensberry_handle_queensclub');

// hook que vem do form Cadastro de Agência
add_action('admin_post_cadastro_agencia', 'cadastro_agencia');
add_action('admin_post_nopriv_cadastro_agencia', 'cadastro_agencia');

// hook que vem do form Trabalhe Conosco
add_action('admin_post_queensberry_trabalhe_conosco', 'queensberry_trabalhe_conosco');
add_action('admin_post_nopriv_queensberry_trabalhe_conosco', 'queensberry_trabalhe_conosco');

// Verificação ReCaptcha do formulário "Receba Novidades"
add_action('admin_post_queensberry_receba_novidades_recaptcha', 'queensberry_verify_recaptcha');
add_action('admin_post_nopriv_queensberry_receba_novidades_recaptcha', 'queensberry_verify_recaptcha');

// Verificação ReCaptcha do formulário "Newsletter Receba Novidades"
add_action('admin_post_queensberry_fale_conosco_recaptcha', 'queensberry_verify_recaptcha');
add_action('admin_post_nopriv_queensberry_fale_conosco_recaptcha', 'queensberry_verify_recaptcha');

// Verificação ReCaptcha do formulário "Programa"
add_action('admin_post_queensberry_programa_recaptcha', 'queensberry_verify_recaptcha');
add_action('admin_post_nopriv_queensberry_programa_recaptcha', 'queensberry_verify_recaptcha');

// Verificação ReCaptcha
add_action('admin_post_queensberry_verify_recaptcha', 'queensberry_verify_recaptcha');
add_action('admin_post_nopriv_queensberry_verify_recaptcha', 'queensberry_verify_recaptcha');


// RESPONSYS PAYLOAD'S

// Recaptcha
function queensberry_verify_recaptcha() {
    $secret_key = "6Lfq8_sqAAAAAGxyoOs1txS7HdsEgPxOhVO-QGOo";
    $client_grecaptcha_res = $_POST["g-recaptcha-response"];

    $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$client_grecaptcha_res}");
    $response_data = json_decode($verify_response, true);

    if($response_data["success"] == true) {
        wp_send_json_success([
            'message' => 'OK',
            'response_data' => $verify_response
        ]);
    } else {
        wp_send_json_error([
            'message' => 'Fail',
            'response_data' => $verify_response,
            'gre_response' => $client_grecaptcha_res
        ]);
    }
}

// Form - Fale Conosco
function queensberry_handle_fale_conosco_sign_up()
{

    // Colocar dados do formulário aqui
    $user_first_name = $_POST["FIRST_NAME"];
    $user_last_name = $_POST["LAST_NAME"];
    $user_cpf = $_POST["CPF_USUARIO"];
    $user_email = $_POST["EMAIL_ADDRESS_"];
    $user_phone_number = $_POST["FULL_PHONE_NUMBER"];
    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];
    $cel_opt_in = $_POST["MOBILE_PERMISSION_STATUS_"];

    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];

    $assunto = $_POST["ASSUNTO"];
    $mensagem = $_POST["MENSAGEM"];

    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    //modelo do payload
    $sign_up_payload = [
        "recordData" => [
            "fieldNames" => [
                "FIRST_NAME",
                "LAST_NAME",
                "CPF_USUARIO",
                "EMAIL_ADDRESS_",
                "MOBILE_NUMBER_",
                "EMAIL_PERMISSION_STATUS_",
                "MOBILE_PERMISSION_STATUS_"
            ],
            "records" => [
                [
                    $user_first_name,
                    $user_last_name,
                    $user_cpf,
                    $user_phone_number,
                    $user_email,
                    $email_opt_in,
                    $cel_opt_in
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule" => [
            "htmlValue" => "H",
            "optinValue" => "I",
            "textValue" => "T",
            "insertOnNoMatch" => true,
            "updateOnMatch" => "REPLACE_ALL",
            "matchColumnName1" => "EMAIL_ADDRESS_",
            "matchColumnName2" => null,
            "matchOperator" => "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];


    $supplemental_register_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records" => [
                [
                    $user_email,
                    "Formulário Fale Conosco Queensberry",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",

    ];

    $profile_ext_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ASSUNTO",
                "MENSAGEM"
            ],
            "records" => [
                [
                    $user_email,
                    $assunto,
                    $mensagem
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",
        "matchColumnName1" => "EMAIL_ADDRESS",
    ];


    $count = 0;

    while ($count < 3) {
        $sign_up_result = queensberry_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/members');


        if ($sign_up_result["status"] == 200) {
            $profile_ext_result = queensberry_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/listExtensions/Pet_Queensberry_Fale_Conosco/members');

            if ($profile_ext_result["status"] == 200) {
                $supplemental_register_result = queensberry_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_QUEENSBERRY/members');

                if ($supplemental_register_result["status"] == 200) {
                    /*wp_send_json_success([
                        "message" => "Cadastro concluído com sucesso!",
                        "data_result" => $sign_up_result,
                        "profile_ext" => $profile_ext_result,
                        "supp_result" => $supplemental_register_result 
                    ]);*/
                    //header('Location: https://queensberryforms.abc7484.sg-host.com/obrigado/');
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

// Form - Popup Cadastro
function queensberry_handle_popup_cadastro()
{

    // Colocar dados do formulário aqui
    $user_first_name = $_POST["FIRST_NAME"];
    $user_last_name = $_POST["LAST_NAME"];
    $user_email = $_POST["EMAIL_ADDRESS_"];
    $user_estado = $_POST["ESTADO"];
    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];
    //$cel_opt_in = $_POST["MOBILE_PERMISSION_STATUS_"];

    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];


    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    //modelo do payload da request body
    $sign_up_payload = [
        "recordData" => [
            "fieldNames" => [
                "FIRST_NAME",
                "LAST_NAME",
                "ESTADO",
                "EMAIL_ADDRESS_",
                "EMAIL_PERMISSION_STATUS_"
            ],
            "records" => [
                [
                    $user_first_name,
                    $user_last_name,
                    $user_estado,
                    $user_email,
                    $email_opt_in
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule" => [
            "htmlValue" => "H",
            "optinValue" => "I",
            "textValue" => "T",
            "insertOnNoMatch" => true,
            "updateOnMatch" => "REPLACE_ALL",
            "matchColumnName1" => "EMAIL_ADDRESS_",
            "matchColumnName2" => null,
            "matchOperator" => "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];


    $supplemental_register_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records" => [
                [
                    $user_email,
                    "Formulário PopUp Cadastro Queensberry",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",

    ];

    $profile_ext_payload = [
        "customEvent" => [
            "eventNumberDataMapping" => null,
            "eventDateDataMapping" => null,
            "eventStringDataMapping" => null
        ],
        "recipientData" => [
            [
                "recipient" => [
                    "customerId" => null,
                    "emailAddress" => $user_email,
                    "listName" => [
                        "folderName" => "!MasterData",
                        "objectName" => "Profile_List_Queensberry"
                    ],
                    "recipientId" => null,
                    "mobileNumber" => null,
                    "emailFormat" => "HTML_FORMAT"
                ]
            ]
        ]
    ];


    $count = 0;

    while ($count < 3) {
        $sign_up_result = queensberry_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/members');
        

        if ($sign_up_result["status"] == 200) {
            $supplemental_register_result = queensberry_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_QUEENSBERRY/members');

            if ($supplemental_register_result["status"] == 200) {
                $profile_ext_result = queensberry_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/events/qb_receba_novidades');

                if ($profile_ext_result["status"] == 200) {
                    wp_send_json_success([
                        "message" => "OK",
                        "data_result" => $sign_up_result,
                        "profile_ext" => $profile_ext_result,
                        "supp_result" => $supplemental_register_result 
                    ]);
                    //header('Location: https://queensberryforms.abc7484.sg-host.com/obrigado/');
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

// Form - Newsletter Receba Novidades
function queensberry_handle_receba_novidades()
{

    // Colocar dados do formulário aqui
    $user_first_name = $_POST["FIRST_NAME"];
    $user_last_name = $_POST["LAST_NAME"];
    $user_email = $_POST["EMAIL_ADDRESS_"];
    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];

    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];


    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    //modelo do payload da request body
    $sign_up_payload = [
        "recordData" => [
            "fieldNames" => [
                "FIRST_NAME",
                "LAST_NAME",
                "ESTADO",
                "EMAIL_ADDRESS_",
                "EMAIL_PERMISSION_STATUS_"
            ],
            "records" => [
                [
                    $user_first_name,
                    $user_last_name,
                    $user_email,
                    $email_opt_in
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule" => [
            "htmlValue" => "H",
            "optinValue" => "I",
            "textValue" => "T",
            "insertOnNoMatch" => true,
            "updateOnMatch" => "REPLACE_ALL",
            "matchColumnName1" => "EMAIL_ADDRESS_",
            "matchColumnName2" => null,
            "matchOperator" => "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];


    $supplemental_register_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records" => [
                [
                    $user_email,
                    " Newsletter Receba Novidades Queensberry",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",

    ];



    $count = 0;

    while ($count < 3) {
        $sign_up_result = queensberry_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/members');


        if ($sign_up_result["status"] == 200) {
            $supplemental_register_result = queensberry_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_QUEENSBERRY/members');

            if ($supplemental_register_result["status"] == 200) {

                /*wp_send_json_success([
                    "message" => "Cadastro concluído com sucesso!",
                    "data_result" => $sign_up_result,
                    "profile_ext" => $profile_ext_result,
                    "supp_result" => $supplemental_register_result 
                ]);*/
                //header('Location: https://queensberryforms.abc7484.sg-host.com/obrigado/');
                return;
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

// Form - Programa
function queensberry_handle_programa()
{

    // Colocar dados do formulário aqui
    $user_first_name = $_POST["FIRST_NAME"];
    $user_last_name = $_POST["LAST_NAME"];
    $user_email = $_POST["EMAIL_ADDRESS_"];
    $user_phone_number = $_POST["FULL_PHONE_NUMBER"];
    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];
    $cel_opt_in = $_POST["MOBILE_PERMISSION_STATUS_"];
    $user_state = $_POST["ESTADO"];
    $user_city = $_POST["CIDADE"];
    $user_perfil = $_POST["PERFIL"];
    $user_message = $_POST["MENSAGEM"];

    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];

    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    //modelo do payload
    $sign_up_payload = [
        "recordData" => [
            "fieldNames" => [
                "FIRST_NAME",
                "LAST_NAME",
                "EMAIL_ADDRESS_",
                "MOBILE_NUMBER_",
                "EMAIL_PERMISSION_STATUS_",
                "MOBILE_PERMISSION_STATUS_",
                "ESTADO",
                "CIDADE"
            ],
            "records" => [
                [
                    $user_first_name,
                    $user_last_name,
                    $user_email,
                    $user_phone_number,
                    $email_opt_in,
                    $cel_opt_in,
                    $user_state,
                    $user_city
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule" => [
            "htmlValue" => "H",
            "optinValue" => "I",
            "textValue" => "T",
            "insertOnNoMatch" => true,
            "updateOnMatch" => "REPLACE_ALL",
            "matchColumnName1" => "EMAIL_ADDRESS_",
            "matchColumnName2" => null,
            "matchOperator" => "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];


    $supplemental_register_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records" => [
                [
                    $user_email,
                    "Formulário Programa Queensberry",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",

    ];

    $profile_ext_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "MENSAGEM"
            ],
            "records" => [
                [
                    $user_email,
                    $user_message
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",
        "matchColumnName1" => "EMAIL_ADDRESS",
    ];


    $count = 0;

    while ($count < 3) {
        $sign_up_result = queensberry_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/members');


        if ($sign_up_result["status"] == 200) {
            $profile_ext_result = queensberry_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/listExtensions/Pet_Queensberry_Programa/members');

            if ($profile_ext_result["status"] == 200) {
                $supplemental_register_result = queensberry_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_QUEENSBERRY/members');

                if ($supplemental_register_result["status"] == 200) {
                    /*wp_send_json_success([
                        "message" => "Cadastro concluído com sucesso!",
                        "data_result" => $sign_up_result,
                        "profile_ext" => $profile_ext_result,
                        "supp_result" => $supplemental_register_result 
                    ]);*/
                    //header('Location: https://queensberryforms.abc7484.sg-host.com/obrigado/');
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

// Form - Recomendar Programa
function queensberry_handle_recomendar_programa()
{

    // Colocar dados do formulário aqui
    $user_first_name = $_POST["FIRST_NAME"];
    $user_last_name = $_POST["LAST_NAME"];
    $user_email = $_POST["EMAIL_ADDRESS_"];
    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];
    $destino = $_POST["DESTINO"];
    $user_message = $_POST["MENSAGEM"];

    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];

    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    //modelo do payload
    $sign_up_payload = [
        "recordData" => [
            "fieldNames" => [
                "FIRST_NAME",
                "LAST_NAME",
                "EMAIL_ADDRESS_",
                "EMAIL_PERMISSION_STATUS_"
            ],
            "records" => [
                [
                    $user_first_name,
                    $user_last_name,
                    $user_email,
                    $email_opt_in
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule" => [
            "htmlValue" => "H",
            "optinValue" => "I",
            "textValue" => "T",
            "insertOnNoMatch" => true,
            "updateOnMatch" => "REPLACE_ALL",
            "matchColumnName1" => "EMAIL_ADDRESS_",
            "matchColumnName2" => null,
            "matchOperator" => "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];


    $supplemental_register_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records" => [
                [
                    $user_email,
                    "Formulário Recomendar Programa Queensberry",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",

    ];

    $profile_ext_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "DESTINO",
                "MENSAGEM"
            ],
            "records" => [
                [
                    $user_email,
                    $destino,
                    $user_message
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",
        "matchColumnName1" => "EMAIL_ADDRESS",
    ];


    $count = 0;

    while ($count < 3) {
        $sign_up_result = queensberry_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/members');


        if ($sign_up_result["status"] == 200) {
            $profile_ext_result = queensberry_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/listExtensions/Pet_Queensberry_Programa/members');

            if ($profile_ext_result["status"] == 200) {
                $supplemental_register_result = queensberry_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_QUEENSBERRY/members');

                if ($supplemental_register_result["status"] == 200) {
                    /*wp_send_json_success([
                        "message" => "Cadastro concluído com sucesso!",
                        "data_result" => $sign_up_result,
                        "profile_ext" => $profile_ext_result,
                        "supp_result" => $supplemental_register_result 
                    ]);*/
                    //header('Location: https://queensberryforms.abc7484.sg-host.com/obrigado/');
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

// Form - Queensclub Cadastro
function queensberry_handle_queensclub()
{

    // Colocar dados do formulário aqui
    $user_first_name = $_POST["FIRST_NAME"];
    $user_last_name = $_POST["LAST_NAME"];
    $user_cpf = $_POST["CPF_USUARIO"];
    $user_civil_state = $_POST["ESTADO_CIVIL"];
    $user_birthyear = $_POST["DATA_NASCIMENTO"];
    $user_phone_number = $_POST["FULL_PHONE_NUMBER"];
    $user_email = $_POST["EMAIL_ADDRESS_"];
    $user_cep = $_POST["CEP_CASA"];
    $user_bairro = $_POST["BAIRRO"];
    $user_endereco = $_POST["ENDERECO"];
    $user_pais = $_POST["PAIS"];
    $user_numero_casa = $_POST["NUMERO_CASA"];
    $user_complemento = $_POST["COMPLEMENTO"];
    $user_cidade = $_POST["CIDADE"];
    $user_estado = $_POST["ESTADO"];
    $user_agencia = $_POST["AGENCIA"];
    $user_atendente = $_POST["ATENDENTE"];
    $user_email_atendente = $_POST["EMAIL_ADDRESS_ATENDENTE"];
    $user_complemento_atendente = $_POST["COMPLEMENTO_ATENDENTE"];
    $user_email_atendente2 = $_POST["EMAIL_ADDRESS_ATENDENTE2"];
    $user_como_conheceu = $_POST["COMO_CONHECEU"];
    $user_frequencia_viaja = $_POST["FREQUENCIA_VIAJA"];
    $user_epoca_viagem = $_POST["EPOCA_VIAGEM"];
    $user_interesse_area = $_POST["INTERESSE_AREA"];



    $email_opt_in = $_POST["EMAIL_PERMISSION_STATUS_"];
    $cel_opt_in = $_POST["MOBILE_PERMISSION_STATUS_"];
    $sign_up_origin = $_POST["ORIGEM_CADASTRO"];
    $sign_up_url = $_POST["URL_CADASTRO"];


    $api_credentials = get_API_credentials();
    $api_key = $api_credentials["authToken"];

    //modelo do payload
    $sign_up_payload = [
        "recordData" => [
            "fieldNames" => [
                "FIRST_NAME",
                "LAST_NAME",
                "CPF_USUARIO",
                "ESTADO_CIVIL",
                "DATA_NASCIMENTO",
                "MOBILE_NUMBER_",
                "EMAIL_ADDRESS_",
                "EMAIL_PERMISSION_STATUS_",
                "MOBILE_PERMISSION_STATUS_",
                "CEP_CASA",
                "BAIRRO",
                "ENDERECO",
                "PAIS",
                "NUMERO_CASA",
                "COMPLEMENTO",
                "CIDADE",
                "ESTADO"
            ],
            "records" => [
                [
                    $user_first_name,
                    $user_last_name,
                    $user_cpf,
                    $user_civil_state,
                    $user_birthyear,
                    $user_phone_number,
                    $user_email,
                    $email_opt_in,
                    $cel_opt_in,
                    $user_cep,
                    $user_bairro,
                    $user_endereco,
                    $user_pais,
                    $user_numero_casa,
                    $user_complemento,
                    $user_cidade,
                    $user_estado
                ]
            ],
            "mapTemplateName" => null
        ],
        "mergeRule" => [
            "htmlValue" => "H",
            "optinValue" => "I",
            "textValue" => "T",
            "insertOnNoMatch" => true,
            "updateOnMatch" => "REPLACE_ALL",
            "matchColumnName1" => "EMAIL_ADDRESS_",
            "matchColumnName2" => null,
            "matchOperator" => "NONE",
            "optoutValue" => "O",
            "rejectRecordIfChannelEmpty" => null,
            "defaultPermissionStatus" => "OPTIN"
        ]
    ];


    $supplemental_register_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "ORIGEM_CADASTRO",
                "URL_CADASTRO"
            ],
            "records" => [
                [
                    $user_email,
                    "Formulário Queensberry Queensclub",
                    $sign_up_url
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",

    ];

    $profile_ext_payload = [
        "recordData" => [
            "fieldNames" => [
                "EMAIL_ADDRESS_",
                "AGENCIA",
                "ATENDENTE",
                "EMAIL_ADDRESS_ATENDENTE",
                "COMPLEMENTO_ATENDENTE",
                "EMAIL_ADDRESS_ATENDENTE2",
                "COMO_CONHECEU",
                "FREQUENCIA_VIAJA",
                "EPOCA_VIAGEM",
                "INTERESSE_AREA"
            ],
            "records" => [
                [
                    $user_email,
                    $user_agencia,
                    $user_atendente,
                    $user_email_atendente,
                    $user_complemento_atendente,
                    $user_email_atendente2,
                    $user_como_conheceu,
                    $user_frequencia_viaja,
                    $user_epoca_viagem,
                    $user_interesse_area
                ]
            ],
            "mapTemplateName" => null
        ],

        "insertOnNoMatch" => true,
        "updateOnMatch" => "REPLACE_ALL",
        "matchColumnName1" => "EMAIL_ADDRESS",
    ];


    $count = 0;

    while ($count < 3) {
        $sign_up_result = queensberry_sign_up_responsys($sign_up_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/lists/Profile_List_Queensberry/members');


        if ($sign_up_result["status"] == 200) {
            $profile_ext_result = queensberry_responsys_profile_extension($profile_ext_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com//rest/api/v1.3/lists/Profile_List_Queensberry/listExtensions/Pet_Queensberry_Cadastro/members');

            if ($profile_ext_result["status"] == 200) {
                $supplemental_register_result = queensberry_responsys_supplemental_table($supplemental_register_payload, $api_key, 'https://i551r8c-api.responsys.ocs.oraclecloud.com/rest/api/v1.3/folders/!MasterData/suppData/SUP_ORIGENS_CADASTROS_QUEENSBERRY/members');

                if ($supplemental_register_result["status"] == 200) {
                    /*wp_send_json_success([
                        "message" => "Cadastro concluído com sucesso!",
                        "data_result" => $sign_up_result,
                        "profile_ext" => $profile_ext_result,
                        "supp_result" => $supplemental_register_result 
                    ]);*/
                    //header('Location: https://queensberryforms.abc7484.sg-host.com/obrigado/');
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

// MAIL FORMS

// Form - Cadastro Agência
function cadastro_agencia()
{

    $cnpj = filter_input(INPUT_POST, "CNPJ_JUR", FILTER_SANITIZE_SPECIAL_CHARS);
    $fantasy_name = filter_input(INPUT_POST, "NOME_FANTASIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $state_registration = filter_input(INPUT_POST, "INSCRICAO_ESTADUAL", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_email = filter_input(INPUT_POST, "EMAIL", FILTER_SANITIZE_EMAIL);
    $legal_name = filter_input(INPUT_POST, "RAZAO_SOCIAL", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "TELEFONE", FILTER_SANITIZE_SPECIAL_CHARS);
    $cadastur = filter_input(INPUT_POST, "CADASTUR", FILTER_SANITIZE_SPECIAL_CHARS);
    $website = filter_input(INPUT_POST, "WEBSITE", FILTER_SANITIZE_URL);

    // Endereço
    $cep = filter_input(INPUT_POST, "CEP_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $neighborhood = filter_input(INPUT_POST, "BAIRRO_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $street = filter_input(INPUT_POST, "RUA_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $state = filter_input(INPUT_POST, "ESTADO_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, "CIDADE_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $number = filter_input(INPUT_POST, "NUMERO_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);
    $complement = filter_input(INPUT_POST, "COMPLEMENTO_AGENCIA", FILTER_SANITIZE_SPECIAL_CHARS);

    // Agente Master
    $agent_name = filter_input(INPUT_POST, "NOME_AGENTE_MASTER", FILTER_SANITIZE_SPECIAL_CHARS);
    $agent_phone = filter_input(INPUT_POST, "TELEFONE_AGENTE_MASTER", FILTER_SANITIZE_SPECIAL_CHARS);
    $agent_cpf = filter_input(INPUT_POST, "CPF_AGENTE_MASTER", FILTER_SANITIZE_SPECIAL_CHARS);
    $agent_mobile = filter_input(INPUT_POST, "CELULAR_AGENTE_MASTER", FILTER_SANITIZE_SPECIAL_CHARS);
    $agent_email = filter_input(INPUT_POST, "EMAIL_AGENTE_MASTER", FILTER_SANITIZE_EMAIL);

    // Dados Financeiros
    $finance_contact_name = filter_input(INPUT_POST, "NOME_CONTATO_FINANCEIRO", FILTER_SANITIZE_SPECIAL_CHARS);
    $finance_contact_phone = filter_input(INPUT_POST, "TELEFONE_CONTATO_FINANCEIRO", FILTER_SANITIZE_SPECIAL_CHARS);
    $finance_responsible = filter_input(INPUT_POST, "RESPONSAVEL_SOCIO", FILTER_SANITIZE_SPECIAL_CHARS);
    $finance_email = filter_input(INPUT_POST, "EMAIL_CONTATO_FINANCEIRO", FILTER_SANITIZE_EMAIL);

    // Políticas de Privacidade
    $privacy_policy = filter_input(INPUT_POST, "POLITICA_PRIVACIDADE", FILTER_SANITIZE_SPECIAL_CHARS);
    $receive_communications = filter_input(INPUT_POST, "RECEBER_COMUNICACOES", FILTER_SANITIZE_SPECIAL_CHARS);

    // Capturando agentes adicionais dinamicamente
    $agents = [];
    // Itera sobre todos os campos do $_POST
    foreach ($_POST as $key => $value) {
        // Verifica se o campo começa com "NOME_AGENTE_"
        if (strpos($key, 'NOME_AGENTE_') === 0) {
            // Extrai o número do agente (por exemplo, "2" de "NOME_AGENTE_2")
            $agente_numero = substr($key, strlen('NOME_AGENTE_'));

            // Coleta os dados do agente
            $agents[] = [
                'numero' => ($agente_numero == 1) ? 'MASTER' : $agente_numero, // Adiciona o número do agente
                'nome' => filter_input(INPUT_POST, "NOME_AGENTE_$agente_numero", FILTER_SANITIZE_SPECIAL_CHARS),
                'telefone' => filter_input(INPUT_POST, "TELEFONE_AGENTE_$agente_numero", FILTER_SANITIZE_SPECIAL_CHARS),
                'cpf' => filter_input(INPUT_POST, "CPF_AGENTE_$agente_numero", FILTER_SANITIZE_SPECIAL_CHARS),
                'celular' => filter_input(INPUT_POST, "CELULAR_AGENTE_$agente_numero", FILTER_SANITIZE_SPECIAL_CHARS),
                'email' => filter_input(INPUT_POST, "EMAIL_AGENTE_$agente_numero", FILTER_SANITIZE_EMAIL)
            ];
        }
    }

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP_DEBUG;
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = SMTP_AUTH;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;

        $mail->setFrom('naoresponda@flytour.com.br', 'Queensberry');
        $mail->addAddress('vitoriapereira.html@gmail.com');
        //$mail->addAddress('suportecomercial@qualitours.com.br');

        $mail->isHTML(true);
        $mail->Subject = 'Queensberry - Cadastro de Agência';

        $agentes_html = '';

        foreach ($agents as $agente) {

            $agentes_html .= 
            <<<HTML
            <div style='width: 100%; max-width: 600px; margin: 0 auto;'>
                <h1 style='font-size: 1.1rem'>Agente {$agente['numero']}</h1>
                <table style='width: 100%;'>
                    <tr>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>Nome:</td>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>{$agente['nome']}</td>
                    </tr>
                    <tr>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>Telefone:</td>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>{$agente['telefone']}</td>
                    </tr>
                    <tr>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>CPF:</td>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>{$agente['cpf']}</td>
                    </tr>
                    <tr>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>Celular:</td>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>{$agente['celular']}</td>
                    </tr>
                    <tr>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>E-mail:</td>
                        <td style='width: 50%; border-bottom: 2px solid #ccc; padding: 10px;'>{$agente['email']}</td>
                    </tr>
                </table>
            </div>
            HTML;        
        }

        $mail->Body =
            <<<HTML
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Queensberry - Cadastro de Agência </title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        </head>

        <body>
            <div style="font-family: Arial; display: block; width: 100%;">
                <p style="text-align: justify; font-size: 1.1rem; ; margin: 0 auto; padding: 20px; max-width: 600px; color: #04004f; ">Um novo cadastro foi realizado através do formulário "Queensberry - Cadastro de Agência". Segue detalhes do cadastro:</p>
                <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 1.1rem">Dados da Agência</h1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">CNPJ:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$cnpj</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Nome fantasia:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$fantasy_name</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Inscrição Estadual:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$state_registration</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">E-mail de Contato:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$contact_email</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Razão Social:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$legal_name</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Telefone:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$phone</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Cadastur:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$cadastur</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Website:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$website</td>
                        </tr>
                    </table>
                </div>

                <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 1.1rem">Endereço da Agência</h1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">CEP:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$cep</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Bairro:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$neighborhood</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Rua/Avenida:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$street</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Estado:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$state</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Cidade:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$city</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Número:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$number</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Complemento:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$complement</td>
                        </tr>
                    </table>
                </div>
                <!-- <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 1.1rem">Agente Master</h1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Nome:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$agent_name</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Telefone:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$agent_phone</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">CPF:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$agent_cpf</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Celular:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$agent_mobile</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">E-mail:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$agent_email</td>
                        </tr>
                    </table>
                </div> -->
        HTML;

        $mail->Body .= $agentes_html;
        $mail->Body .= 
            <<<HTML
                <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 1.1rem">Dados Financeiros</h1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Nome do Contato Financeiro:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$finance_contact_name</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Telefone do Contato Financeiro:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$finance_contact_phone</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Responsável Sócio:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$finance_responsible</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">E-mail do Contato Financeiro:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$finance_email</td>
                        </tr>
                    </table>
                </div>
                <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                        <h1 style="font-size: 1.1rem">Políticas de Privacidade</h1>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Ao informar meus dados eu aceito a
                                    Política de Privacidade:</td>
                                <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Sim</td>
                            </tr>
                            <tr>
                                <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Aceito receber comunicações e
                                informações da BeFly:</td>
                                <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Sim</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </body>
            </html>
        HTML;
        $mail->CharSet = "UTF-8";
        $mail->AltBody = 'Este email requer visualização em HTML';

        foreach ($_FILES as $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }
        }

        $mail->send();

        header("Location: https://queensberryforms.abc7484.sg-host.com/obrigado/");
    } catch (Exception $e) {
        wp_send_json_error([
            'message' => 'Email não enviado',
        ]);

        return;
    }
}

// Form - Trabalhe Conosco
function queensberry_trabalhe_conosco()
{

    $nome = filter_input(INPUT_POST, "FIRST_NAME", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "EMAIL_ADDRESS_", FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_input(INPUT_POST, "MOBILE_NUMBER_", FILTER_SANITIZE_SPECIAL_CHARS);
    $cargo = filter_input(INPUT_POST, "CARGO", FILTER_SANITIZE_EMAIL);



    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP_DEBUG;
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = SMTP_AUTH;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;

        $mail->setFrom('naoresponda@flytour.com.br', 'Queensberry');
        $mail->addAddress('vitoriapereira.html@gmail.com');
        //$mail->addAddress('suportecomercial@qualitours.com.br');

        $mail->isHTML(true);
        $mail->Subject = 'BeFly - Cadastro de Agência';

        $mail->Body =
            <<<HTML
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Queensberry - Trabalhe Conosco </title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        </head>

        <body>
            <div style="font-family: Arial; display: block; width: 100%;">
                <p style="text-align: justify; font-size: 1.1rem; ; margin: 0 auto; padding: 20px; max-width: 600px; color: #04004f; ">Um novo cadastro foi realizado através do formulário "Queensberry - Trabalhe Conosco". Segue detalhes do cadastro:</p>
                <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 1.1rem">Dados</h1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Nome:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$nome</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">E-mail:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$email</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Telefone:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$telefone</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Cargo:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">$cargo</td>
                        </tr>
                    </table>
                </div>

                <div style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <h1 style="font-size: 1.1rem">Políticas de Privacidade</h1>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Ao informar meus dados eu aceito a
                                Política de Privacidade:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Sim</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Aceito receber comunicações e
                            informações da BeFly:</td>
                            <td style="width: 50%; margin: 0; border-bottom: 2px solid #ccc; padding: 10px ;">Sim</td>
                        </tr>
                    </table>
                </div>
            </div>
        </body>

        </html>
        HTML;

        $mail->CharSet = "UTF-8";
        $mail->AltBody = 'Este email requer visualização em HTML';

        foreach ($_FILES as $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $mail->addAttachment($file['tmp_name'], $file['name']);
            }
        }

        $mail->send();

        header("Location: https://queensberryforms.abc7484.sg-host.com/obrigado/");
    } catch (Exception $e) {
        wp_send_json_error([
            'message' => 'Email não enviado',
        ]);

        return;
    }
}



// não mexer nas 3 funções do apocalípse abaixo (fazem as requisições)

function queensberry_sign_up_responsys($sign_up_payload, $key, $url)
{
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

function queensberry_responsys_profile_extension($sign_up_payload, $key, $url)
{
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

function queensberry_responsys_supplemental_table($sign_up_payload, $key, $url)
{
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

// api credentials 
function get_API_credentials()
{
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