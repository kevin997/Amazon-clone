import React, { useState, useEffect} from "react";
import { useForm } from "react-hook-form";

import { IMAGES } from "../../configurations/images";
import "./index.css";

function Login(){

    const {
        register,
        formState,
        formState: { errors, isSubmitSuccessful },
        handleSubmit,
    } = useForm();

    const onSubmit = (data) => {
        console.log(data);
    };

    return(
        <div className="login">
            <img className="hide-bg image" src={IMAGES.amazonLogo} alt="logo" />
            <div className="form-border">
                <header>S'identifier</header>
                <div className="form">
                    <form className="login-form" method="post" action="" onSubmit={handleSubmit(onSubmit)}>
                        <label htmlFor="userEmail">Adresse e-mail</label>
                        <input type="email" name="userEmail" id="userEmail" {...register("email", {required : "Adresse email requise."})} aria-invalid={errors.email ? "true" : "false"} />
                        {errors.email && (
                            <p role="alert" className="text-error">
                                {errors.email?.message}
                            </p>
                        )}

                        <label htmlFor="userPassword">Mot de passe</label>
                        <input type="password" name="userPassword" id="userPassword" {...register("password", {required:"Mot de passe requis."})} aria-invalid={errors.password ? "true" : "false"} />
                        {errors.password && (
                            <p role="alert" className="text-error">
                                {errors.password?.message}
                            </p>
                        )}

                        <input type="submit" name="btnSubmit" id="btnSubmit" value="S'identifier" />

                        <label className="special-label">
                            <input type="checkbox" className="rememberMe" id="rememberMe" name="rememberMe"/>
                            <i className="a-icon a-icon-checkbox"></i>
                            <span className="a-label a-checkbox-label">Rester connecté</span>
                        </label>
                    </form>

                    <p className="legal-info">
                        En passant votre commande, vous acceptez les
                        <a href="#">conditions générales de vente</a> d'Amazon.
                        Veuillez consulter notre <a href="#">Notice Protection de vos informations personnelles</a>,
                        notre <a href="#">Notice cookies</a> et notre <a href="#">Notice Annonces publicitaires basées sur vos centres d’intérêt</a>.
                    </p>

                    <div className="divider"></div>                    
                    <p className="buyforwork">
                    Vous achetez pour votre entreprise ?{" "}
                        <a href="#">Acheter sur Amazon Business</a>
                    </p>

                    <div className="divider"></div> 
                    <p className="register">
                        Nouveau ? <a href="#">Créer un compte</a>
                    </p>
                </div>
            </div>
        </div>
    );

}

export default Login;