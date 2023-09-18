import React, { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import "../landing/landing.css";

function Abonnement() {

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

            <h1>Gestion des abonnements Prime.</h1>

            <div className="form-container">
                    <form className="abonnement-prime-form" onSubmit={handleSubmit(onSubmit)}>
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
                                placeholder="Description breve de l'abonnement ..."
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
                            <label htmlFor="formule">formule</label>
                            <select name="formule" id="formule">
                                <option value="0">Selectionner une option</option>
                                <option value="mensuel">Mensuel</option>
                                <option value="annuel">Annuel</option>
                            </select>
                        </div> 
                        
                        <div className="form-group">
                            <label htmlFor="forfait">Montant</label>
                            <input 
                                type="number" 
                                name="forfait" 
                                placeholder="10500.00 FCFA" 
                                {...register(
                                    "forfait", 
                                    { required: "Forfait requis." },
                                    { min: 0.3 }
                                )} aria-invalid={errors.forfait ? "true" : "false"}                                
                            />
                            {errors.forfait && (
                                <p role="alert" className="text-error">
                                    {errors.forfait?.message}
                                </p>
                            )}
                        </div>

                        <input type="hidden" name="id"/><br/>                 
                       
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Ajouter" />
                    </form>
                </div>
                <div className="table-container">
                    <table className="tab-abonnement">
                        <thead>
                            <tr>
                                <th>Nº ordre</th>
                                <th>Libelle</th>
                                <th>Description</th>
                                <th>Formule</th>
                                <th>Forfait</th>
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

export default Abonnement;