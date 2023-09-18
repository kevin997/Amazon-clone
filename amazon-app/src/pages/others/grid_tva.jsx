import React, { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import "../landing/landing.css";

function Tva() {

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

            <h1>Gestion des taux TVA.</h1>

            <div className="form-container">
                    <form className="tva-form" onSubmit={handleSubmit(onSubmit)}>
                        <div className="form-group">
                            <label htmlFor="taux">taux</label>
                            <input 
                                type="number" 
                                name="taux"
                                placeholder="0.3 FCFA" 
                                {...register(
                                    "taux", 
                                    { required: "Taux requis."}
                                )} aria-invalid={errors.name? "true" : "false"}
                            />
                            {errors.taux && (
                                <p role="alert" className="text-error">
                                    {errors.taux?.message}
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

                        <input type="hidden" name="id"/><br/>                 
                       
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Ajouter" />
                    </form>
                </div>
                <div className="table-container">
                    <table className="tab-tva">
                        <thead>
                            <tr>
                                <th>Nº ordre</th>
                                <th>Taux</th>
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

export default Tva;