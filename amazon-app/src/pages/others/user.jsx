import React, { useState, useEffect } from "react";
import { useForm } from "react-hook-form";
import "../landing/landing.css";
import ListUser from "../../components/ListUser";

function User() {

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

            <h1>Gestion des utilisateurs.</h1>

            <div className="form-container">
                    <form className="user-form" onSubmit={handleSubmit(onSubmit)}>
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
                            <label htmlFor="email">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                {...register(
                                    "email", 
                                    { required: "Email requis."}
                                )} aria-invalid={errors.email ? "true" : "false"}
                            />
                            {errors.email && (
                                <p role="alert" className="text-error">
                                    {errors.email?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="password">Motde passe</label>
                            <input 
                                type="password" 
                                name="password" 
                                {...register(
                                    "password", 
                                    { required: "Password requis."}
                                )} aria-invalid={errors.password? "true" : "false"}
                            />
                            {errors.password && (
                                <p role="alert" className="text-error">
                                    {errors.password?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="password_confirmation">Confirmation</label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                {...register(
                                    "password_confirmation", 
                                    { required: "Confirmation de mot de passe requise."}
                                )} aria-invalid={errors.password_confirmation? "true" : "false"}
                            />
                            {errors.password_confirmation && (
                                <p role="alert" className="text-error">
                                    {errors.password_confirmation?.message}
                                </p>
                            )}
                        </div>

                        <input type="hidden" name="id"/><br/>
                        
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Ajouter" />
                    </form>
                </div>
                <div className="table-container">
                    <ListUser/>
                </div>
        </div>
    )

}

export default User;