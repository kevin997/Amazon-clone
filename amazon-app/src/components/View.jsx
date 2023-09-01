import React,  { useEffect } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";

const View = () => {

    const {id}=useParams();

    const [productData, setProductData] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchData();
    },[id]);

    const fetchData = async() => {
        try {
            const result = await axios.get("http:/127.0.0.1:8080/api/catalogue/produit/"+id);
            //console.log(result.data.produit);
            setProductData(result.data.produit);
        } catch (err) {
            console.log(err);
        }
    };

    const clicToBackHandle = () =>{
        navigate("/");
    };

    return (
        <div>
            <div className="container">
                <div className="row">
                    <div className="col-md-12">

                        <h1>Product Details</h1>
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>n° ID</th>
                                    <th>Designation</th>
                                    <th>Fiche technique</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>{produit.id}</td>
                                    <td>{product.designation}<br /><strong>{product.prix_unitaire}</strong></td>
                                    <td>{product.unite_emballage}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div className="container d-flex justify-content-center">
                <div><button className="btn btn-primary" onClick={clicToBackHandle}>Back To Home</button></div>
            </div>
        </div>
    )
};

export default View;