import React, { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import "../landing/landing.css";

function PlanVente() {

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

    return (
        <div className="main-container">

            <h1>Gestion des plans de vente.</h1>

            <div className="form-container">
                    <form className="plan-vente-form" onSubmit={handleSubmit(onSubmit)}>
                        <div className="form-group">
                            <label htmlFor="name">Libelle</label>
                            <input 
                                type="text" 
                                name="name" 
                                {...register(
                                    "name", 
                                    { required: "Libelle requis."}
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
                                placeholder="Description breve du plan de vente ..."
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
                            <label htmlFor="montant">Montant</label>
                            <input 
                                type="number" 
                                name="montant" 
                                placeholder="25590.55 FCFA" 
                                {...register(
                                    "montant", 
                                    { required: "Montant requis." },
                                    { min: 0.3 }
                                )} aria-invalid={errors.montant ? "true" : "false"}                                
                            />
                            {errors.montant && (
                                <p role="alert" className="text-error">
                                    {errors.montant?.message}
                                </p>
                            )}
                        </div>

                        <input type="hidden" name="id"/><br/>
                        
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Ajouter" />
                    </form>
                </div>
                <div className="table-container">
                    <table className="tab-plan">
                        <thead>
                            <tr>
                                <th>Nº ordre</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Montant</th>
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

export default PlanVente;