<?php
// STANDAARD FUNCTIES ------------------------------------------
// Inloggen
function login($params)
{
    // JSON decoden
    $params = json_decode($params);

    // Variabelen uit object halen
    $s_mail = $params->mail;
    $s_password = $params->password;

    if($s_mail == 'test')
    {
        // Gelukt
        $a_result = array('status' => 'success', 'therapist_uuid' => '28e23bf2-5885-4029-9a9c-6471237db2e8', 'practice_uuid' => '28e23bf2-5885-4029-9a9c-6471237db2e8');
    }
    else
    {
        // Niet gelukt
        $a_result = array('status' => 'unsuccessful');
    }

    // Resultaat terugsturen
    echo json_encode($a_result);
}

// Wachtwoord vergeten
function forgotPassword($params)
{
    // JSON decoden
    $params = json_decode($params);

    // Variabelen uit object halen
    $s_mail = $params->mail;

    if($s_mail == 'test')
    {
        // Gelukt
        $a_result = array('status' => 'sent');
    }
    else
    {
        // Niet gelukt
        $a_result = array('status' => 'not sent');
    }

    // Resultaat terugsturen
    echo json_encode($a_result);
}

// Wachtwoord wijzigen
function changePassword($params)
{
    // JSON decoden
    $params = json_decode($params);

    // Variabelen uit object halen
    $s_therapist_uuid = $params->therapist_uuid;
    $s_practice_uuid = $params->practice_uuid;
    $s_oldPassword = $params->oldPassword;
    $s_newPassword = $params->newPassword;

    if($s_oldPassword == 'test')
    {
        // Gelukt
        $a_result = array('status' => 'success');
    }
    else
    {
        // Niet gelukt
        $a_result = array('status' => 'unsuccessful');
    }

    // Resultaat terugsturen
    echo json_encode($a_result);
}