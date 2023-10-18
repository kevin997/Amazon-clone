import React, { useState, useEffect} from 'react';
import axios from "axios";
import { useNavigate } from "react-router-dom";
import Button from 'react-bootstrap/Button';
import Container from 'react-bootstrap/Container';
import Form from 'react-bootstrap/Form';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import NavDropdown from 'react-bootstrap/NavDropdown';
import { useForm } from "react-hook-form";

import Validation from "../components/Validation";


import { IMAGES } from "../configurations/amazon_images";
import Basket from "./basket";

function AmazonNavBar(){

    // on verifie si on a un token valide
    let userInfos = JSON.parse(localStorage.getItem("loggedUser"));

    // initialisation du basket pour voir s'il y a un produit pour affichage
    const userBasket = new Basket();

    // initialisation de la variable de traitement des erreurs axios
    const [errors, setErrors] = useState({});

    // initialisation de la variable de traitement des erreurs axios
    const [message, setMessage] = useState({});

    // deconnexion du compte
    const logout = (e) => {
        e.preventDefault()

        // parametrage des entetes requete cote serveur
        let headers = {
            "Accept": "application/json",
            "X-CSRF-Token": userInfos.access_token,
            "withCredentials": true,
            "Authorization": "Bearer " + userInfos.access_token
        }

        axios.get("http://127.0.0.1:8000/sanctum/csrf-cookie", { headers : {withCredentials: true} }).then(response => {
            console.log(JSON.stringify(response))
        });

        //axios.post("http://127.0.0.1:8000/api/logout", { headers: headers }).then(response => {

            //console.log(response.data);

            //navigate("/");
            
        //}).catch(error => {
            //console.log(error);

            //if(error.response) {
                //if (error.response.data.message) {
                    //setMessage(error.response.data.message);
                //}

                //if (error.response.data.errors) {
                    //setErrors(error.response.data.errors);
                //}
            //}
        //});
    }

    const login = (e) => {
        console.log("Hello world !");
    }


    return (
        <Navbar bg="secondary" expand="md">  
            <Container>  
                <Navbar.Brand href="/">
                    <img src={IMAGES.amazonLogo} alt="logo"/>
                </Navbar.Brand>

                <Navbar.Toggle aria-controls="basic-navbar-nav" />

                <Nav.Link href="#">Votre adresse de livraison :<br/> <label>Cameroun</label></Nav.Link> 

                <form className="search-form">
                    <div className="form-group">
                        <select name="categorie" onChange={ e => changeHandle(e) }>
                            <option value="">Toutes nos categories</option><option value="1">Automobile</option><option value="2">Produits pour bebe</option><option value="3">Book Music Video DVD</option><option value="4">Informatique</option><option value="5">Jeux vidéo et Consoles</option><option value="6">Produits électroniques grand public</option><option value="7">DIY et Outils</option><option value="8">Jardin & Extérieur</option><option value="9">Cuisine & Maison</option><option value="10">Gros électroménager</option><option value="11">Luminaires</option><option value="12">Instruments de musique</option><option value="13">Fournitures de bureau</option><option value="14">Articles pour animaux de compagnie</option><option value="15">Chaussures et Accessoires</option><option value="16">Logiciels et Jeux PC</option><option value="17">Articles de sport</option><option value="18">Jeux et Jouets</option><option value="19">Épicerie</option><option value="20">Bijoux</option><option value="21">Montres</option><option value="22">Montres</option><option value="23">Vêtements</option><option value="24">Bières, Vins et Spiritueux</option><option value="25">Beauté</option><option value="26">Santé et Soins</option><option value="27">Appareils de soins personnels</option>
                        </select>
                        
                        <input type="search" placeholder="Rechercher sur Amazon" className="me-2" aria-label="Search"/>

                        <input type="submit" className="nav-input nav-progressive-attribute" onClick={ e => searchHandle(e) } value=""/>
                    </div>                                
                </form> 

                <Navbar.Collapse id="basic-navbar-nav">  
                    <Nav className="me-auto">

                        <NavDropdown title={(userInfos != null)? `Bonjour ${userInfos.user.name}`: `Bonjour, Identifiez-vous`} id="basic-nav-dropdown">
                            <NavDropdown.Divider />
                                {(userInfos == null)? (
                                    <button onClick={login} className="btn btn-warning sm">Identifiez-vous</button>
                                ):(``)}
                              
                            <NavDropdown.Item href="#action/3.1">Dropdown Item 1</NavDropdown.Item>  
                            <NavDropdown.Item href="#action/3.2">Dropdown Item 2</NavDropdown.Item>  
                            

                            <NavDropdown.Divider />
                            {(userInfos != null)? (
                                <NavDropdown.Item href="#" onClick={logout}>Deconnexion</NavDropdown.Item>
                            ):(``)}
                        </NavDropdown>

                        <Nav.Link href="#link">Retours et commandes</Nav.Link>  
                    </Nav>

                    <Nav>  
                        <Nav.Link href="#" title="Panier">
                            <span className="total-cart-item">{userBasket.getNumberProduct()}</span>
                            <img src={IMAGES.amazonCart} alt="logo"/>
                        </Nav.Link>  
                    </Nav>  
                </Navbar.Collapse>  
            </Container>  
        </Navbar>      
    )
}
export default AmazonNavBar;