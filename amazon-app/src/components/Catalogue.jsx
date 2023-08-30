import React,  { useState, useEffect } from "react";
import axios from "axios";


const Catalogue = () => {

    const [productData, setProductData] = useState([]);

    //useEffect(() => { fetchData(); },[]);

    const getProduits = async () => {
        try {
            const response = await axios.get("http:/127.0.0.1:8080/api/catalogue/produit");
            console.log(response.data);
            //setProductData(result.data.produit);
        } catch (err) {
            console.log(err);
        }
    };


    return(
        <>
            <div className="catalogue-produits">
                <div className="categorie-produit">
                    <div className="bloc-produit"></div>
                </div>
            </div>
        </>
    );
}

export default Catalogue;