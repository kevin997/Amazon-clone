import React, { useState, useEffect } from "react";
import axios from "axios";
import { useForm } from "react-hook-form";
import "../landing/landing.css";
import ListUser from "../../components/ListUser";
import Validation from "../../components/Validation";

function User() {

    // initialisation de la variable de recuperation des champs et son setter
    const [userField, setUserField] = useState({
        password: "",
        password_confirmation: "",
        name:"",
        email:""
    });

    // initialisation de la variable de traitement des erreurs
    const [errors, setErrors] = useState({});

    // initialisation de la variable de loader et son setter
    const [loading, setLoading] = useState(false);

    // gestion de l'event onchange() pour recuperer les changements dans les champs
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

        // on change l'etat du setter s'il y a eu des erreurs
        setErrors(Validation(userField));

        if(Object.keys(Validation(userField)).length === 0){

            // Pas d'erreurs, on procede a la soumission du formulaire
            try {
                const result = await axios.post("http://127.0.0.1:8000/api/register", userField);
                // console.log(result.data.user);

                // on reset tous les champs
                setUserField({
                    password: "",
                    password_confirmation: "",
                    name: "",
                    email: ""
                });

            } catch (error) {
                console.log(error);
            }
        }        
    }

    return (
        <div className="container">
            <div className="row">
                <h1 style={{'textAlign':'center'}}>Gestion des utilisateurs.</h1>
                <div className="col-3">
                    <form className="user-form">
                        <h3>Nouveau ...</h3>

                        <div className="form-group">
                            <label htmlFor="name">Nom </label>
                            <input 
                                type="text" 
                                name="name"
                                value={userField.name}
                                placeholder="Entrer votre nom"
                                onChange={ e => changeUserFieldHandle(e) }
                                aria-invalid={errors.name? "true" : "false"}
                            />
                            {errors.name && (
                                <p role="alert" className="text-error">
                                    {errors.name}
                                </p>
                            )}                            
                        </div>

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

                        <div className="form-group">
                            <label htmlFor="password_confirmation">Confirmation</label>
                            <input 
                                type="password" 
                                name="password_confirmation"
                                placeholder="**************"
                                value={userField.password_confirmation}
                                onChange={ e => changeUserFieldHandle(e) }
                                aria-invalid={errors.password_confirmation? "true" : "false"}
                            />
                            {errors.password_confirmation && (
                                <p role="alert" className="text-error">
                                    {errors.password_confirmation}
                                </p>
                            )}
                        </div>

                        <div className="form-group" style={{textAlign:'center'}}>
                            <br/>
                            <button type="submit" className="btn btn-primary btn-sm col-5" onClick={e => onSubmitChange(e)}>Ajouter</button>
                        </div>
                    </form>
                </div>
                <div className="col-9">
                    <ListUser/>
                </div>                
            </div>
        </div>
    )

}

export default User;