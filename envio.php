<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário estão preenchidos
    if (isset($_POST["nome_fornecedor"]) && isset($_POST["nome_responsavel"]) && isset($_POST["valor"]) && isset($_POST["cliente"]) && isset($_POST["data"]) && isset($_POST["assunto"]) && isset($_POST["text_message"]) && isset($_POST["email_fornecedor"])) {

        // Processar os dados do formulário aqui
        // ...

        // Exibir mensagem de sucesso
        $mensagemEnviado = exibirMensagemEnviado();
        echo $mensagemEnviado;
    } else {
        // Exibir mensagem de erro
        $mensagemErro = exibirMensagemErro();
        echo $mensagemErro;
    }
}

function exibirMensagemEnviado()
{
    return "<script>
            Swal.fire('Enviado!', 'O formulário foi enviado com sucesso!', 'success');
          </script>";
}

function exibirMensagemErro()
{
    return "<script>
            Swal.fire('Erro', 'O formulário não está preenchido', 'warning');
          </script>";
}

header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST['Enviar'])) {

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP(); // Send using SMTP 
        $mail->Host = 'smtp.mailgun.org'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'postmaster@acordo.catalogodicol.me'; // SMTP username
        $mail->Password = 'cA7L%Qn3xxtF83ctiPyYY4nYQCw@$Q'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('postmaster@acordo.catalogodicol.me', 'Formulário de Acordo Comercial');

        $nome_fornecedor = $_POST['nome_fornecedor'];
        $nome_responsavel = $_POST['nome_responsavel'];
        $cliente = $_POST['cliente'];
        $assunto = $_POST['assunto'];
        $valor = $_POST['valor'];
        $pedido_ref = $_POST['pedido_ref'];
        $data = $_POST['data'];
        $text_message = $_POST['text_message'];
        $protocolo = $_POST['protocolo'];
        $email_fornecedor = $_POST['email_fornecedor'];


        $data_formatada = date("d/m/Y", strtotime($data));

        if ($nome_fornecedor == "Ricardo - Dicol") {
            $mail->addAddress('ricardo.cirilo@dicoldistribuidora.com.br');
        } elseif ($nome_fornecedor == "Rodrigo - Dicol") {
            $mail->addAddress('rodrigo@dicoldistribuidora.com.br');
        } else {
            // Adicione outros endereços de e-mail aqui
            $mail->addAddress($email_fornecedor);
            $mail->addAddress('alex@dicoldistribuidora.com.br');
            $mail->addAddress('rodrigo@dicoldistribuidora.com.br');
            $mail->addAddress('juliane@dicoldistribuidora.com.br');
            $mail->addAddress('ricardo.cirilo@dicoldistribuidora.com.br');
        }

        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Formulário de Acordo Comercial</title>
            <style>
                /* Estilos gerais */
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                    line-height: 1.4;
                    color: #333333;
                }

                /* Estilos específicos do Outlook */
                table {
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                }

                /* Estilos do contêiner */
                .container {
                    max-width: 600px;
                    height: 600px;
                    margin: 0 auto;
                }

                /* Estilos do logotipo */
                .logo {
                    max-width: 150px;
                    max-height: 150px;
                    margin: 0 auto;
                    display: block;
                }

                /* Estilos do conteúdo */
                .content {
                    padding: 20px;
                    background-color: #ffffff;
                    border: 1px solid #dddddd;
                }

                /* Estilos dos títulos */
                h2 {
                    margin-top: 0;
                    margin-bottom: 20px;
                    font-size: 24px;
                    line-height: 1.2;
                    color: #041144;
                }

                h4 {
                    margin-top: 0;
                    margin-bottom: 10px;
                    font-size: 18px;
                    line-height: 1.2;
                    color: #041144;
                }

                /* Estilos dos detalhes */
                p {
                    margin: 0 0 10px;
                }

                strong {
                    font-weight: bold;
                }

                /* Estilos do rodapé */
                .footer {
                    padding: 20px;
                    background-color: #f5f5f5;
                    text-align: center;
                    font-size: 12px;
                    color: #999999;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="content">
                    <img src="cid:header_image" alt="Dicol Distribuidora">
                    <hr>
                    <h2>Formulário de Acordo Comercial</h2>
                    <h3>Informações do Acordo</h3>
                    <p><strong style="color: red;">' . $protocolo . '</strong></p>
                    <p><strong>Assunto:</strong> ' . $assunto . '</p>
                    <p><strong>Nome do Fornecedor:</strong> ' . $nome_fornecedor . '</p>
                    <p><strong>Nome do Responsável:</strong> ' . $nome_responsavel . '</p>
                    <p><strong>Cliente:</strong> ' . $cliente . '</p>
                    <p><strong><span style="color: red;">Verba: ' . $valor . '</span></strong></p>
                    <p><strong>Mensagem:</strong> ' . $text_message . '</p>
                    <hr>
                    <h4>Complemento</h4>
                    <p><strong>Referência do Pedido:</strong> ' . $pedido_ref . '</p>
                    <p><strong>Data:</strong> ' . $data_formatada . '</p>
                </div>
                <div class="footer">
                    Este é um e-mail automático. Por favor, não responda a este e-mail.
                </div>
            </div>
        </body>
        </html>';

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Cliente: ' . $cliente;
        $mail->Body = $body;
        $mail->CharSet = 'UTF-8';
        $mail->AddEmbeddedImage('/var/www/html/header.png', 'header_image', 'header.png', 'base64', 'image/png');

        if ($mail->send()) {
            exibirMensagemEnviado();
            header("Location: http://20.168.235.58");
        } else {
            exibirMensagemErro();
        }
    } catch (Exception $e) {
        exibirMensagemErro();
    }
}
