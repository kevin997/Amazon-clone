//on commence par importer React ainsi que les hocks utiles
import React,  { useEffect } from "react";
import Catalogue from "../../components/Catalogue.jsx";

import "./landing.css";

import { IMAGES } from "../../configurations/images";

function Home() {
    return (
        <div className="page">
            <div className="header">            
                <div className="nav-left">
                    <div className="nav-logo">
                        <a className="logo-home-link" href="" alt="clone amazon">
                            <img className="hide-bg" src={IMAGES.amazonLogo} alt="logo" />
                        </a>
                    </div>
                    <div className="nav-location">
                        <span className="nav-line-1 nav-progressive-content" id="line-content-1">Votre adresse de livraison :</span>
                        <span className="nav-line-2 nav-progressive-content" id="line-content-2">Pays - Cameroun</span>
                    </div>                
                </div>
                <div className="nav-fill">
                    <div className="nav-search">
                        <form id="nav-search-bar-form" method="post" action="" role="search">
                            <span className="nav-search-scope nav-sprite">
                                <select name="categorie_produit" id="categorie_produit" className="cat-produit">
                                    <option value="search-alias=aps">Toutes nos catégories</option>
                                </select>
                            
                                <input type="text" className="nav-input nav-progressive-attribute" id="twotabsearchtextbox" placeholder="Rechercher Amazon.fr" />
                            
                                <input type="submit" className="nav-input nav-progressive-attribute" id="nav-search-submit-button" value="  " />
                            </span>
                        </form>
                    </div>
                </div>
                <div className="nav-right">
                    <div className="who-is-connect">
                        <span>Bonjour, <br/><a href="" className="signup-link">identifiez-vous</a></span>
                    </div>

                    <div className="orders-history">
                        <span><a href="" className="orders-link">Vos commandes</a></span>
                    </div>

                    <div className="cart-container">
                        <div id="nav-cart-count-container">
                            <span id="nav-cart-count">0</span>
                            <span id="nav-cart-icon"></span>
                        </div>
                        
                        <div id="nav-cart-text-container">
                            <span id="nav-cart-label">Panier</span>
                        </div>                    
                    </div>                
                </div>
                <div className="sub-nav-bar"></div>
            </div>

            <div className="main">
            <Catalogue />
            </div>
        </div>
        
    );
}

export default Home;
