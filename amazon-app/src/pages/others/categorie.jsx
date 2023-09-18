import React,  { useEffect, useState } from "react";
import { useForm } from "react-hook-form";
import {Button} from "react-bootstrap";

import "../landing/landing.css";

function Categorie(){

    const {
        register,
        formState,
        reset,
        watch,
        getValues,
        formState: { errors, isSubmitSuccessful },
        handleSubmit,
    } = useForm();

    const onSubmit = (data) => {
        console.log(data);
    };

    useEffect(() => {
        if (formState.isSubmitSuccessful) {
            reset({
                name: "",
                password_repeat: "",
                email:""
            });
        }
    }, [formState, reset]);

    return (
        <div className="main-container">

            <h1>Gestion des categories produit.</h1>

            <div className="form-container">
                    <form className="categorie-form" onSubmit={handleSubmit(onSubmit)}>
                        <div className="form-group">
                            <label htmlFor="name">Nom</label>
                            <input 
                                type="text" 
                                name="name" 
                                {...register(
                                    "name", 
                                    { required: "Nom requis."}
                                )} aria-invalid={errors.name ? "true" : "false"}
                            />
                            {errors.name && (
                                <p role="alert" className="text-error">
                                    {errors.name?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="details">Description</label>
                            <textarea 
                                name="details"
                                placeholder="Description breve de la categorie ..."
                                {...register(
                                    "details",
                                    { required: "Description requise." }
                                )} aria-invalid={errors.details? "true" : "false"}
                            />
                            {errors.details && (
                                <p role="alert" className="text-error">
                                    {errors.details?.message}
                                </p>
                            )}
                        </div> 
                        
                        <div className="form-group">
                            <label htmlFor="frais_vente_min">Frais vente</label>
                            <input 
                                type="number" 
                                name="frais_vente_min" 
                                placeholder="0.3 FCFA" 
                                {...register(
                                    "frais_vente_min", 
                                    { required: "Frais de vente mini requis." },
                                    { min: 0.3 }
                                )} aria-invalid={errors.frais_vente_min ? "true" : "false"}                                
                            />
                            {errors.frais_vente_min && (
                                <p role="alert" className="text-error">
                                    {errors.frais_vente_min?.message}
                                </p>
                            )}

                            <input 
                                type="number" 
                                name="frais_vente_max"
                                placeholder="0.3 FCFA"
                                {...register(
                                    "frais_vente_max",
                                    { required : "Frais de vente max requis." },
                                    { min: 0.3}
                                )} aria-invalid={errors.frais_vente_max? "true" : "false"}                                
                            />
                            {errors.frais_vente_max && (
                                <p role="alert" className="text-error">
                                    {errors.frais_vente_max?.message}
                                </p>
                            )}
                        </div>
                        
                        <div className="form-group">
                            <label htmlFor="frais_expedition">Frais d'expedition</label>
                            <input 
                                type="number" 
                                name="frais_expedition"
                                placeholder="0.3 FCFA"
                                {...register(
                                    "frais_expedition",
                                    { required: "Frais d'expedition requis." },
                                    { min: 0.3}
                                )} aria-invalid={errors.frais_expedition? "true" : "false"}                                
                            />
                            {errors.frais_expedition && (
                                <p role="alert" className="text-error">
                                    {errors.frais_expedition?.message}
                                </p>
                            )}
                        </div>                        

                        <div className="form-group">
                            <label htmlFor="frais_retour">Frais de traitement retour</label>
                            <input 
                                type="number" 
                                name="frais_retour"
                                placeholder="0.3 FCFA"
                                {...register(
                                    "frais_retour",
                                    { required: "Frais de traitement retour requis." },
                                    { min: 0.3 }
                                )} aria-invalid={errors.frais_retour ? "true" : "false"}                                
                                />
                            {errors.frais_retour && (
                                <p role="alert" className="text-error">
                                    {errors.frais_retour?.message}
                                </p>
                            )}
                        </div>                        

                        <div className="form-group">
                            <label htmlFor="frais_stockage">Frais de stockage</label>
                            <input 
                                type="number" 
                                name="frais_stockage"
                                placeholder="0.3 FCFA"
                                {...register(
                                    "frais_stockage",
                                    { required: "Frais de stockage requis." },
                                    { min: 0.3 }
                                )} aria-invalid={errors.frais_stockage? "true" : "false"}                                
                                />
                            {errors.frais_stockage && (
                                <p role="alert" className="text-error">
                                    {errors.frais_stockage?.message}
                                </p>
                            )}
                        </div> 

                        <input type="hidden" name="id" /><br/>

                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Ajouter" />
                    </form>
                </div>
                <div className="table-container">
                    <table className="tab-categorie">
                        <thead>
                            <tr>
                                <th>Nº ordre</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
        </div>
    )
}
export default Categorie;