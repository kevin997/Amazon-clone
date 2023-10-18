import React, { useEffect, useState } from "react";
import axios from "axios";
import dateFormat from "dateformat";
import { useParams, useNavigate } from "react-router-dom";

function UserView () {

    // initialisation de la variable de donnees et du setter
    const [user, setUser] = useState([]);

    // initialisation de la navigation entre les pages
    const navigate = useNavigate();

    // initialisation du parametre a transmettre (id)
    const {id} = useParams();

    // afficher l'utilisateur concerne
    const fetchUser = async () => {

        try {
            const result = await axios.get("http://127.0.0.1:8000/api/view_user/"+id);
            //console.log(result.data.user);
            setUser(result.data.user);
        } catch (err) {
            console.log("Inexistant, redirection vers 404 !");
        }
    }

    // n'executer la fonction "fetchUser()" qu'une seule fois
    useEffect (() => {
        fetchUser();
    }, [id]);

    // retour au dashboard de l'admin
    const clickToBackHandle = () =>{
        navigate("/User");
    }

    return (
        <div>
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        
                        <h1>Details de l'utilisateur</h1>
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>Nº ordre</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Inscris le</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr key={user.id}>
                                    <td>{user.id}</td>
                                    <td>{user.name}</td>
                                    <td>{user.email}</td>
                                    <td>{dateFormat(user.created_at, "dd-mm-yyyy")}</td>                                    
                                </tr>                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div className="container d-flex justify-content-center">
                <div><button className="btn btn-primary me-lg-2" onClick={clickToBackHandle}>Back To Home</button></div>
            </div>
        </div>
        
    )
}
export default UserView;