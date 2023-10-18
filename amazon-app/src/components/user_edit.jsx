import React, { useState, useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";

const UserEdit = () => {

    // initialisation de la navigation entre les pages
    const navigate = useNavigate();

    // initialisation du parametre a transmettre (id)
    const {id} = useParams();

    // initialisation de la variable destinee a recuperer les donnees des champs et du setter
    const [userField, setUserField] = useState({
        name: "",
        email: ""
    });

    // recuperation des donnees dans la bd pour affichage dans le form d'edition
    useEffect(() => {
        fetchUser();
    }, [id]);
    
    const fetchUser = async() => {

        try {
            const result = await axios.get("http://127.0.0.1:8000/api/edit_user/"+id);
            // console.log(result.data.user);
            setUserField(result.data.user);
        } catch (err) {
            console.log("Inexistant, redirection vers 404 !");
        }
    }

    // retour au dashboard de l'admin
    const clickToBackHandle = () =>{
        navigate("/User");
    }

    // gestion de l'event onchange() pour recuperer les changements dans les champs
    const changeUserFieldHandle = (e) => {
        setUserField({
            ...userField,
            [e.target.name]: e.target.value
        });

        console.log(userField);
    }

    // mise a jour
    const onSubmitChange = async (e) => {
        e.preventDefault();

        try {
            await axios.patch("http://127.0.0.1:8000/api/update_user/"+id, userField);

            navigate("/User");
        } catch (err) {
            console.log("Something wrong.");
        }

    }

    return(
        <div className="container">
            <h1>Editer le details de {""}</h1>

            <form>            
                <div className="col-sm-4">
                    <label className="form-label">Nom </label>
                    <input 
                        type="text" 
                        className="form-control col-xs-3" 
                        name="name"
                        value={userField.name}
                        onChange={ e => changeUserFieldHandle(e) }                  
                    />
                </div>
                <div className="col-sm-4">
                    <label className="form-label">Email </label>
                    <input 
                        type="email" 
                        className="form-control col-xs-3" 
                        name="email"
                        value={userField.email}
                        onChange={ e=>changeUserFieldHandle(e) }                   
                    />
                    <input type="hidden" name="id" value={id} />                   
                </div>

                <div className="col-sm-1">
                    <br/>
                    <button type="submit" className="btn btn-primary" onClick={ e=>onSubmitChange(e) }>Update</button><br/>
                </div>

                <div className="col-sm-5">
                    <div className="container d-flex justify-content-center">
                        <div><button className="btn btn-link me-lg-2" onClick={clickToBackHandle}>Back To Home</button></div>
                    </div>
                </div>
            </form>
        </div>
    )
}

export default UserEdit;