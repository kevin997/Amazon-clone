export default function Validation(values) {
    
    // initialisation de la variable errors
    const errors = {}

    // definition du regex pattern de l'email
    //const email_pattern = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/;
    const email_pattern = /^[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-A-Za-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[-A-Za-z0-9]*[A-Za-z0-9])?$/i;

    // definition du regex pattern du password
    // const password_pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/;
    const password_pattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,})$/;

    if(values.name === ""){
        errors.name = "Nom requis.";
    }

    if(values.email === ""){
        errors.email = "Adresse email requise.";
    }else{
        if(!email_pattern.test(values.email))
            errors.email = "Format incorrect de l'adresse email";
    }

    if(values.password === ""){
        errors.password = "Mot de passe requis.";
    }else if(!password_pattern.test(values.password)){        
        errors.password = "Format incorrect du mot de passe.";
    }

    if(values.password_confirmation === "" || values.password !== values.password_confirmation){
        errors.password_confirmation = "Mots de passe non concordants.";
    }

    return errors;
}