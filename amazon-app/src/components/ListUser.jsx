import React, { useState, useEffect } from "react";
import axios from "axios";
import { Result } from "postcss";

function ListUser() {

    useEffect(() => {
        fetchData();
    }, [])

    const fetchData = async () => {

        try {
            const result = await axios ("http://127.0.0.1:8000/api/users");
            console.log(result.data);
        } catch (err) {
            console.log("Something wrong");
        }

    }

    return (
        <div className="container">
            <h3>Details utilisateurs</h3>
            
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
                <tbody>
                    
                </tbody>
            </table>
        </div>
    );
}
export default ListUser;