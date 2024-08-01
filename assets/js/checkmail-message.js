document.addEventListener("DOMContentLoaded", () => {

    if(document.documentElement.lang === "en-GB") {
        document.getElementsByClassName("um-postmessage")[0].innerText = "Thank you very much for registering. Before you can log in, we need you to activate your account by clicking on the activation link in the email we just sent you."
    }
    if(document.documentElement.lang === "ca") {
            document.getElementsByClassName("um-postmessage")[0].innerText = "Moltes gràcies per registrar-te. Abans que puguis iniciar sessió, necessitem que activis el teu compte fent clic en l'enllaç d'activació del correu electrònic que acabem d'enviar-te."
    }
    
    


    

});