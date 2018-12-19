<?php

/*
 * GC MailSender
 * 
 * Version 1.0.0 (2015-07-27)
 * 
 * Copyright (c) 2015 Ali Mantar (http://webkolog.net)
 * 
 * Licensed under the MIT license (http://mit-license.org/)
 * 
 */

include_once("class.phpmailer.php");

class MailSender {

    public function __construct() {
        
    }

    public static function sendMail($toMail, $toName = FALSE, $mailSubject, $mailMessage, $fromMail = FALSE, $fromName = FALSE, $p_signature = FALSE) {
        $signature = "

---------
İyi Günler Dileriz
www." . SITE_DOMAIN . " Sitesi Yönetimi
Bilgi için: " . SITE_INFO_MAIL . "
Destek Hizmetleri: " . SITE_SUPPORT_MAIL . "
" . COMPANY_ADDRESS . "
Bu elektronik posta ve onunla iletilen bütün dosyalar gizlidir. Sadece yukarıda isimleri belirtilen kişiler arasında özel haberleşme amacını taşımaktadır. Size yanlışlıkla ulaşmıssa bu elektronik postanın içeriğini açıklamanız, kopyalamanız, yönlendirmeniz ve kullanmanız kesinlikle yasaktır. Lütfen mesajı geri gönderiniz ve sisteminizden siliniz. " . SITE_DOMAIN . " bu mesajın içeriği ile ilgili olarak hiç bir hukuksal sorumluluğu kabul etmez... ";
        $Signature = ($p_signature ? $p_signature : $signature);
        
        //#TEST BAŞ
        echo nl2br(str_replace('\r\n', '<br>', $mailMessage.$Signature));
        //#TEST BİT
        /*
        $toName = $toName ? $toName : $toMail;
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->CharSet = "UTF-8";
          $mail->SMTPAuth = true;
          $mail->Port = 587;
          $mail->Host = MAIL_HOST;
          $mail->Username = MAIL_USER;
          $mail->Password = MAIL_PASS;
          if ($fromMail) {
          $fromName = $fromName ? $fromName : $fromMail;
          $mail->SetFrom($fromMail, $fromName);
          } else {
          $mail->SetFrom(SITE_MAIL, SITE_TITLE);
          }
          $mail->Subject = $mailSubject;
          $mail->MsgHTML(nl2br(str_replace('\r\n', '<br>', $mailMessage.$Signature)));
          $mail->IsHTML(true);
          $mail->AddAddress($toMail, $toName);

          if (!$mail->Send()) {
          echo $mail->ErrorInfo;
          return FALSE;
          } else {
          return TRUE;
          }
          */
    }

}
