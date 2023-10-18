//on commence par importer React ainsi que les hocks utiles
import React,  { useEffect, useState } from "react";
import ProductList from "../../components/ListProducts";
import AmazonNavBar from "../../components/NavBar";

import "./landing.css";



function Home() {
    

    return (
        <div className="container-fluid">
            <div className="justify-content-md-center">
                <AmazonNavBar/>
            </div>

            <div className="row">
                <ProductList/>
            </div>

            <div className="row"></div>
        </div>
        
    );
}

export default Home;
