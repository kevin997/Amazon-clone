import React, { useState, useEffect } from "react";
import { NavLink, useParams } from "react-router-dom";
import axios from "axios";
import dateFormat from "dateformat";

import { Result } from "postcss";
import Pagination from "./pagination";
import "bootstrap/dist/css/bootstrap.min.css";
//import "../pages/landing/landing.css";


function ListUser() {
    // initialisation de la variable de recuperation des users et de son setter
    const [userData, setUserdata] = useState([]);
    const [loading, setLoading] = useState(false);
    const [currentPage, setCurrentPage] = useState(1);
    const [postsPerPage] = useState(10);
    
    // afficher la liste des utilisateurs
    const fetchUserData = async () => {
        try {
            const res = await axios.get("http://127.0.0.1:8000/api/users");
            //console.log(result.data.results);
            setUserdata(res.data.results);

            setLoading(false);
        } catch (err) {
            console.log(err);
        }            
    }
    
    // N'effectue la fonction fetchUserData() qu'une seule fois 
    useEffect(() => {
        setLoading(true);
        fetchUserData();
    }, []);

    if(loading && userData.length === 0){
        return <h2>Loading ...</h2>
    }

    // Get current posts
    const indexOfLastPost = currentPage * postsPerPage;
    const indexOfFirstPost = indexOfLastPost - postsPerPage;
    const currentPosts = userData.slice(indexOfFirstPost, indexOfLastPost);
    const howManyPages = Math.ceil(userData.length/postsPerPage);

    // suppression d'un utilisateur
    const handleDelete = async(id) => {
        //console.log(id);
        await axios.delete("http://127.0.0.1:8000/api/delete_user/"+id);

        const newUserData = userData.filter((item)=>{
            return (
                item.id !== id
            )
        });

        setUserdata(newUserData);
    }

    if(loading && userData.length === 0){
        return (
            <h2>Loading ....</h2>
        )
    }

    

    return (
        <div className="container-table">
            <h3  style={{textAlign:'center'}}>Listing des utilisateurs</h3>
            
            <table className="tab-user">
                <thead>
                    <tr>
                        <th>Nº ordre</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Inscris le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr><td colSpan={5}></td></tr>
                </tfoot>
                <tbody>
                {
                    currentPosts.map((user) => {
                        return (
                            <tr key={user.id}>
                                <td>{user.id}</td>
                                <td>{user.name}</td>
                                <td>{user.email}</td>
                                <td>{dateFormat(user.created_at, "dd-mm-yyyy")}</td>
                                <td>
                                    <NavLink to={`/user_view/${user.id}`} className="btn btn-success col-sm-3">Voir</NavLink> 
                                    <NavLink to={`/user_edit/${user.id}`} className="btn btn-info col-sm-3">Editer</NavLink> 
                                    <button onClick={()=>handleDelete(user.id)} className="btn btn-danger col-5">Supprimer</button>
                                </td>
                            </tr>
                        )
                    })
                }                    
                </tbody>
            </table>
            
            <Pagination pages={ howManyPages } setCurrentPage={ setCurrentPage }/>
        </div>
    );
}
export default ListUser;