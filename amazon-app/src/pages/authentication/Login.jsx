import React, { useState, useEffect} from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

import { useForm } from "react-hook-form";
import Validation from "../../components/Validation";

import { IMAGES } from "../../configurations/amazon_images";
import "./index.css";

function Login(){

    // initialisation de la variable de recuperation des champs et son setter
    const [userField, setUserField] = useState({
        remember: false,
        password: "",
        email:""
    });

    // initialisation de la variable de traitement des erreurs des champs de saisie
    const [wrongInput, setWrongInput] = useState({});

    // initialisation de la variable de traitement des erreurs axios
    const [errors, setErrors] = useState({});

    const [userLogged, setUserLogged] = useState();

    const navigate = useNavigate();

    // Recuperation des champs modifies (event sur les champs)
    const changeUserFieldHandle = (e) => {
        e.preventDefault();

        // recuperation des contenus des champs dans la variable setUserField
        setUserField({
            ...userField,
            [e.target.name]: e.target.value
        });
        
    }

    const onSubmitChange = async (e) => {

        // on empeche la soumission par defaut        
        e.preventDefault();

        // on change l'etat de la variable de validation des champs pour valider les donnees saisies
        setWrongInput(Validation(userField));
        
        if(Object.keys(Validation(userField)).length !== 0){
            
            // Pas d'erreurs, on procede a la soumission du formulaire
            try {

                const instance = axios.create({
                    baseURL: 'http://localhost:8000',
                    timeout: 1000,
                    withCredentials: true,
                    xsrfCookieName: 'XSRF-TOKEN',
                    xsrfHeaderName: 'X-XSRF-TOKEN'
                  });
                
                // make request first to sanctum/csrf-cookie
                await axios.get("http://127.0.0.1:8000/sanctum/csrf-cookie", instance).then((response) => {

                    const payload = {
                        remember: userField.remember,
                        email: userField.email,
                        password: userField.password
                    };

                    console.log(JSON.stringify(response));
                    
                    //if(userField.remember) {    // se souvenir de moi ?
                        //payload.remember = true;
                    //}

                    axios.post("http://127.0.0.1:8000/api/login", payload, { headers: { 'Accept': 'application/json' } }).then(response => {

                        console.log(response.data);

                        if(response.data.user) {
                            // on stocke le contenu de la variable "response" dans le localstorage
                            localStorage.setItem("loggedUser", JSON.stringify(response.data));                            

                            // on charge les informations de l'utilisateur connecte
                            setUserLogged(response.data.user);

                            navigate("/");
                        }
                    }).catch(error => {
                        console.log(error);

                        if(error.response) {
                            if (error.response.data.message) {
                                setMessage(error.response.data.message);
                            }

                            if (error.response.data.errors) {
                                setErrors(error.response.data.errors);
                            }
                        }
                    });
                });

                // on reset tous les champs
                setUserField({
                    remember: false,
                    password: "",
                    email: ""
                });

            } catch (error) {
                console.log(error);
            }
        }        
    }

    return(
        <>
            <div className="container-fluid">
                <div className="row">
                    <div className="login">
                        <img className="hide-bg image" src={IMAGES.amazonLogoForPages} alt="logo" />

                        <div className="form-border">
                            <header>S'identifier</header>
                            <div className="form">
                                <form className="login-form">
                                    <div className="form-group">
                                        <label htmlFor="email">Email</label>
                                        <input 
                                            type="email" 
                                            name="email"
                                            value={userField.email}
                                            placeholder="Entrer votre adresse email"
                                            onChange={ e => changeUserFieldHandle(e) }
                                            aria-invalid={errors.email? "true" : "false"}
                                        />
                                        {errors.email && (
                                            <p role="alert" className="text-error">
                                                {errors.email}
                                            </p>
                                        )}
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="password">Mot de passe</label>
                                        <input 
                                            type="password" 
                                            name="password"
                                            value={userField.password}
                                            placeholder="**************"
                                            onChange={ e => changeUserFieldHandle(e) }
                                            aria-invalid={errors.password? "true" : "false"} 
                                        />
                                        {errors.password && (
                                            <p role="alert" className="text-error">
                                                {errors.password}
                                            </p>
                                        )}
                                    </div>

                                    <div className="form-group" style={{textAlign:'center'}}>
                                        <br/>
                                        <button type="submit" className="btn btn-primary btn-sm col-5" onClick={e => onSubmitChange(e)}>S'authentifier</button>
                                    </div>

                                    <label className="special-label">
                                        <input type="checkbox" className="rememberMe" id="rememberMe" name="rememberMe" onChange={ e => changeUserFieldHandle(e) }/>
                                        <i className="a-icon a-icon-checkbox"></i>
                                        <span className="a-label a-checkbox-label">Rester connecté</span>
                                    </label>
                                </form>

                                <p className="legal-info">
                                    En passant votre commande, vous acceptez les <a href="#">conditions générales de vente</a> d'Amazon. Veuillez consulter notre <a href="#">Notice Protection de vos informations personnelles</a>, notre <a href="#">Notice cookies</a> et notre <a href="#">Notice Annonces publicitaires basées sur vos centres d’intérêt</a>.
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
                </div>
            </div>
        </>
        
    );

}

export default Login;