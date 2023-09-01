import React,  { useEffect } from "react";
import { navLink } from "react-router-dom";
import axios from "axios";

function Catalogue() {

    const [productData, setProductData] = useState([]);

    useEffect(() => {
        fetchData();
    },[]);

    const fetchData = async () => {
        try {
            const result = await axios("http:/127.0.0.1:8080/api/catalogue/produit");
            // console.log(result.data.produit);
            setProductData(result.data.produit);
        } catch (err) {
            console.log(err);
        }
    };

    const handleDelete = async (id) => {
        await axios.delete("http:/127.0.0.1:8080/api/delete_product/" + id);

        const newProduitData = productData.filter((item) => {
            return (
                item.id !== id
            );
        });

        setProductData(newProduitData);
    };


    return (
        <div className="container">
            <h3>Catalogue des produits</h3>
            <table className="table table-bordered">
                <thead>
                    <tr>
                        <th>n° Ordre</th>
                        <th>Designation</th>
                        <th>Fiche technique</th>
                        <th colspan='3'>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    {productData.map((product, i) => {
                        return (
                            <tr key={product.id}>
                                <td>{(i < 10) ? "0" + i : i}</td>
                                <td>
                                    {product.designation}<br />
                                    <strong>{product.prix_unitaire}</strong>
                                </td>
                                <td>{product.unite_emballage}</td>
                                <td><navLink to={`/show_produit/${product.id}`} className="btn btn-success mx-2">Voir</navLink></td>
                                <td><navLink to={`/update_product/${product.id}`} className="btn btn-info mx-2">Modifier</navLink></td>
                                <td><button onClick={() => handleDelete(product.id)} className="btn btn-danger">Supprimer</button></td>
                            </tr>
                        );
                    })}
                </tbody>
            </table>
        </div>
    );

}

export default Catalogue;