<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Settings;
use Illuminate\Support\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class IletisimController extends Controller
{
    public function ContactPage() {
        $contact = Contact::all();
        $company_settings = Settings::find(1);
        $social_media = Settings::find(1);
        return view('frontend.pages.contact_page', compact('contact','company_settings','social_media'));
    }

    public function StoreMessage(Request $request){
        // require  base_path('vendor/autoload.php');
        // $settings = Settings::find(1);
        
        // $mail = new PHPMailer(true);

        // try {
                               
        //     $mail->isSMTP();                               
        //     $mail->Host       = $settings->mail_server;                
        //     $mail->SMTPAuth   = true;                                 
        //     $mail->Username   = $settings->email;                
        //     $mail->Password   = $settings->mail_sifre;                            
        //     $mail->SMTPSecure = $settings->protokol;            
        //     $mail->Port       = $settings->mail_port;                                    

           
        //     $mail->setFrom($settings->email, $settings->site_name);
        //     $mail->addAddress($settings->email);     
   
        //     $name = $request->name;
        //     $email = $request->email;
        //     $phone = $request->phone;
        //     $subject = $request->subject;
        //     $message = $request->message;

        //     $mail->isHTML(true);                                  
        //     $mail->Subject = 'Web Site Mail';
        //     $mail->Body    = "Adı : ". $name."<br> ". "Mail Adresi :  ". $email."<br> ". "Telefon :  ". $phone."<br> ". "Konu :  ". $subject."<br> "."Mesaj :  ". $message ;

        //     if( !$mail->send() ) {
        //         return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
        //     }
            
        //     else {
        //         Contact::insert([
        //             'name' => $request->name,
        //             'email' => $request->email,
        //             'phone' => $request->phone,
        //             'subject' => $request->subject,
        //             'message' => $request->message
        //         ]);
        //         return back()->with("success", "Email has been sent.");
        //     }
        // } catch (Exception $e) {
        //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }
        
        
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Your Message Submited Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
