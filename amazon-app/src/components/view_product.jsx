import React, { useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import productsData from "./s_datas/produits.json";
import Basket from "../components/basket.js";
import "./customStyle.css";


function Product(){
    
    // initialisation de la variable product et de son setter
    const [products, setProducts] = useState([]);

    const [quantityToBasket, setQuantityToBasket] = useState([]);

    // initialisation de la navigation entre les pages
    const navigate = useNavigate();

    // id produit passe en parametre
    const {id} = useParams();

    const product = productsData.find(product => product.id == id);
    //console.log(product);

    // gestion de l'event onchange() pour recuperer les changements de quantite
    const changeQuantityHandle = (e) => {
        e.preventDefault();

        // recuperation de la nouvelle quantite
        setQuantityToBasket({
            ...quantityToBasket,
            [e.target.name]: e.target.value
        });        
    }

    const onSubmitHandle = (e) => {

        // initialisation de la classe Basket
        let basket = new Basket();

        // on empeche la soumission par defaut        
        e.preventDefault();

        // initialisation de la variable destinee a contenir le produit du panier
        let basketLine = {
            "id": product.id,
            "name": product.designation,
            "price": product.prix_unitaire,
            "image": product.details.photo_1,
            "quantity": quantityToBasket.quantity
        }
        
        // enregistrement de la ligne dans le panier
        basket.add(basketLine);

        setQuantityToBasket({
            "quantity": 1
        });
    }

    // retour au catalogue
    const clickToBackHandle = () =>{
        navigate("/");
    }
    
    return(
        <div className="container-fluid" style={{"padding":"2% 10%"}}>
            <div className="row">
                <div className="bloc-image col">
                    <div className="product-image"><img src={product.details.photo_1} style={{width:"100%", height:"70%"}} /></div>
                </div>

                <div className="bloc-details col">
                    <p className="product-title">{product.designation}</p>
                    <p className="product-price">{product.prix_unitaire} <sup> FCFA</sup></p>
                    <p className="product-disponibility">{product.etat}</p>
                    <p className="product-description">{product.details.description}</p>
                </div>

                <div className="bloc-cart col">
                    <form className="product-form">
                        <div className="form-group">
                            <label htmlFor="quantity">Quantité :</label>
                            <select name="quantity" onChange={ e => changeQuantityHandle(e) }>
                                <option value={1}>1</option><option value={2}>2</option><option value={3}>3</option><option value={4}>4</option><option value={5}>5</option>
                            </select>                                                   
                        </div>

                        <div className="form-group" style={{textAlign:'center'}}>
                            <br/>
                            <button type="submit" className="btn btn-primary btn-sm col-5" onClick={e => onSubmitHandle(e)}>Ajouter au Panier</button>
                        </div>
                    </form>
                    <div className="container d-flex justify-content-center">
                        <div><button className="btn btn-link me-lg-2" onClick={clickToBackHandle}>Retour au catalogue</button></div>
                    </div>
                </div> 
            </div>
        </div>
    )
}
export default Product;