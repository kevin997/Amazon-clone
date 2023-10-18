import React from "react";
import { NavLink, useParams } from "react-router-dom";
import productsData from "./s_datas/produits.json";
import "./customStyle.css";

const ProductList = ()=>{
    
    return (
        <div className="container">
            <div className="row">
                <h2>Notre catalogue de produits</h2>
            {
                productsData.map((product) => (
                    <div key={product.id} className="item col-4">                        
                        <NavLink to={`/view_product/${product.id}`} className="btn btn-light">
                            <div className="image-container">
                                <img src={product.details.photo_1} alt=">)" style={{"width":"256px", "height":"172px"}} />
                            </div>
                            <div className="details-container">
                                <div className="price-details">{product.prix_unitaire}<sup> FCFA</sup></div>
                                <div className="title-details">{product.designation.slice(0,70)+"..."}</div>
                            </div>                            
                        </NavLink>                        
                    </div>
                ))
            }                
            </div>
        </div>
    )
}

export default ProductList;