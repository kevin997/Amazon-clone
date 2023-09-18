import React,  { useEffect, useState } from "react";
import { useForm } from "react-hook-form";
import {Button} from "react-bootstrap";

import "../landing/landing.css";

function Produit(){

    const {
        register,
        formState,
        reset,
        watch,
        getValues,
        formState: { errors, isSubmitSuccessful },
        handleSubmit,
    } = useForm();

    const onSubmit = (data) => {
        console.log(data);
    };

    useEffect(() => {
        if (formState.isSubmitSuccessful) {
            reset({
                designation: "",
                prix_unitaire: 10.00,
                niveau_alerte:10.00,
                seuil_recomplement:10.00
            });
        }
    }, [formState, reset]);

    return (
        <div className="main-container">

            <h1>Gestion des produits.</h1>

            <div className="form-container">
                    <form className="product-form" onSubmit={handleSubmit(onSubmit)}>
                        <div className="form-group">
                            <label htmlFor="designation">Designation</label>
                            <input 
                                type="text" 
                                name="designation" 
                                {...register(
                                    "designation", 
                                    { required: "Designation requise."}
                                )} aria-invalid={errors.designation ? "true" : "false"}
                            />
                            {errors.designation && (
                                <p role="alert" className="text-error">
                                    {errors.designation?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="prix_unitaire">Prix unitaire</label>
                            <input 
                                type="number" 
                                name="prix_unitaire" 
                                {...register(
                                    "prix_unitaire", 
                                    { required: "Prix unitaire requis."},
                                    { min: 0.5}
                                )} aria-invalid={errors.prix_unitaire? "true" : "false"}
                            />
                            {errors.prix_unitaire && (
                                <p role="alert" className="text-error">
                                    {errors.prix_unitaire?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="niveau_alerte">Niveau d'alerte</label>
                            <input 
                                type="number" 
                                name="niveau_alerte" 
                                {...register(
                                    "niveau_alerte", 
                                    { required: "Niveau d'alerte requis."},
                                    { min: 10}
                                )} aria-invalid={errors.niveau_alerte? "true" : "false"}
                            />
                            {errors.niveau_alerte && (
                                <p role="alert" className="text-error">
                                    {errors.niveau_alerte?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="seuil_recompletement">Seuil de recomplement</label>
                            <input 
                                type="number" 
                                name="seuil_recompletement" 
                                {...register(
                                    "seuil_recompletement", 
                                    { required: "Seuil de recomplement requis."},
                                    { min: 10}
                                )} aria-invalid={errors.seuil_recomplement? "true" : "false"}
                            />
                            {errors.seuil_recomplement && (
                                <p role="alert" className="text-error">
                                    {errors.seuil_recomplement?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="categorie">Categorie</label>
                            <select name="categorie" id="categorie"></select>
                        </div>

                        <div className="form-group">
                            <label htmlFor="unite_emballage">Unite emballage</label>
                            <select name="unite_emballage" id="unite_emballage">
                                <option value="carton">Carton</option><option value="Casier">Casier</option>
                                <option value="boite">Boite</option><option value="paquet">Paquet</option>
                            </select>
                        </div>

                        <div className="form-group">
                            <label htmlFor="devise">Devise</label>
                            <select>
                                <option value="Afghani">Afghani</option><option value="Rand">Rand</option>
                                <option value="Lek">Lek</option><option value="Dinar algérien">Dinar algérien</option>
                                <option value="Euro">Euro</option><option value="Kwanza">Kwanza</option>
                                <option value="Dollar des Caraïbes orientales">Dollar des Caraïbes orientales</option><option value="Dollar américain">Dollar américain</option>
                                <option value="Florin des Antilles">Florin des Antilles</option><option value="Riyal saoudien">Riyal saoudien</option>
                                <option value="Peso argentin">Peso argentin</option><option value="Dram arménien">Dram arménien</option>
                                <option value="Florin d'Aruba">Florin d'Aruba</option><option value="Dollar australien">Dollar australien</option>
                                <option value="Manat">Manat</option><option value="Dollar des Bahamas">Dollar des Bahamas</option>
                                <option value="Dinar de Bahreïn">Dinar de Bahreïn</option><option value="Taka">Taka</option>
                                <option value="Dollar de Barbade">Dollar de Barbade</option><option value="Rouble bélorusse">Rouble bélorusse</option>
                                <option value="Dollar de Belize">Dollar de Belize</option><option value="Franc CFA - BCEAO">Franc CFA - BCEAO</option>
                                <option value="Franc CFA - BEAC" selected>Franc CFA - BEAC</option><option value="Dollar des Bermudes">Dollar des Bermudes</option>
                                <option value="Rhoupie indienne">Rhoupie indienne</option><option value="Ngultrum">Ngultrum</option>
                                <option value="Boliviano">Boliviano</option><option value="Mvdol">Mvdol</option>
                                <option value="Mark convertible">Mark convertible</option><option value="Pula">Pula</option>
                                <option value="Couronne norvégienne">Couronne norvégienne</option><option value="Real">Real</option>
                                <option value="Dollar de Brunei">Dollar de Brunei</option><option value="Bulgarian Lev">Bulgarian Lev</option><option value="Franc du Burundi">Franc du Burundi</option>
                                <option value="Dollar des Iles Caïmans">Dollar des Iles Caïmans</option><option value="Riel">Riel</option><option value="Dollar canadien">Dollar canadien</option>
                                <option value="Escudo du Cap-Vert">Escudo du Cap-Vert</option><option value="Peso chilien">Peso chilien</option><option value="Yuan">Yuan</option>
                                <option value="Peso colombien">Peso colombien</option><option value="Franc des Comores">Franc des Comores</option><option value="Franc Congolais">Franc Congolais</option>
                                <option value="Dollar néo-zélandais">Dollar néo-zélandais</option><option value="Won">Won</option><option value="Colon de Costa Rica">Colon de Costa Rica</option>
                                <option value="Kuna">Kuna</option><option value="Peso cubain">Peso cubain</option>
                                <option value="Couronne danoise">Couronne danoise</option><option value="Franc de Djibouti">Franc de Djibouti</option><option value="Peso dominicain">Peso dominicain</option>
                                <option value="Dollar des Caraïbes orientales">Dollar des Caraïbes orientales</option><option value="Livre égyptienne">Livre égyptienne</option><option value="Colon du El Salvador">Colon du El Salvador</option>
                                <option value="Dollar des Etats-Unis">Dollar des Etats-Unis </option><option value="Dirham des émirats arabes unis">Dirham des émirats arabes unis</option><option value="Nakfa">Nakfa</option>
                                <option value="Birr éthiopien">Birr éthiopien</option><option value="Livre de Falkland">Livre de Falkland</option><option value="Dollar de Fidji">Dollar de Fidji</option>
                                <option value="Dalasi">Dalasi</option><option value="Lari">Lari</option><option value="Ghana Cedi">Ghana Cedi</option>
                                <option value="Livre de Gibraltar">Livre de Gibraltar</option><option value="Quetzal">Quetzal</option><option value="Franc guinéen">Franc guinéen</option>
                                <option value="Peso de Guinée-Bissau">Peso de Guinée-Bissau</option><option value="Dollar de Guyane">Dollar de Guyane</option><option value="Lempira">Lempira</option>
                                <option value="Dollar de Hong-Kong">Dollar de Hong-Kong</option><option value="Forint">Forint</option><option value="Rupiah">Rupiah</option>
                                <option value="Rial iranien">Rial iranien</option><option value="Dinar iraquien">Dinar iraquien</option><option value="Couronne islandaise">Couronne islandaise</option>
                                <option value="Nouveau israëli sheqel">Nouveau israëli sheqel</option><option value="Dollar jamaïcain">Dollar jamaïcain</option><option value="Yen">Yen</option>
                                <option value="Dinar jordanien">Dinar jordanien</option><option value="Tenge">Tenge</option><option value="Shilling du Kenya">Shilling du Kenya</option>
                                <option value="Som">Som</option><option value="Dinar koweïtien">Dinar koweïtien</option><option value="Kip">Kip</option>
                                <option value="Rans">Rans</option><option value="Livre libanaise">Livre libanaise</option><option value="Dollar libérien">Dollar libérien</option>
                                <option value="Dinar libyen">Dinar libyen</option><option value="Franc suisse">Franc suisse</option><option value="Pataca">Pataca</option>
                                <option value="Denar">Denar</option><option value="Malagasy Ariary">Malagasy Ariary</option><option value="Ringgit de Malaisie">Ringgit de Malaisie</option>
                                <option value="Kwacha">Kwacha</option><option value="Rufiyaa">Rufiyaa</option><option value="Livre maltaise">Livre maltaise</option>
                                <option value="Dirham marocain">Dirham marocain</option><option value="Roupie de Maurice">Roupie de Maurice</option><option value="Ouguija">Ouguija</option>
                                <option value="Peso mexicain">Peso mexicain</option><option value="Leu de Moldavie">Leu de Moldavie</option><option value="Tugrik">Tugrik</option>
                                <option value="Metical">Metical</option><option value="Kyat">Kyat</option><option value="Dollar namibien">Dollar namibien</option>
                                <option value="Roupie du Népal">Roupie du Népal</option><option value="Cordoba Oro">Cordoba Oro</option><option value="Naira">Naira</option>
                                <option value="Franc CFP">Franc CFP</option><option value="Rial Omani">Rial Omani</option><option value="Shilling ougandais">Shilling ougandais</option>
                                <option value="Soum d'Ouzbékistan">Soum d'Ouzbékistan</option><option value="Roupie du Pakistan">Roupie du Pakistan</option><option value="Balboa">Balboa</option>
                                <option value="Kina">Kina</option><option value="Guarani">Guarani</option>
                                <option value="Nouveau Sol">Nouveau Sol</option><option value="Peso philippin">Peso philippin</option><option value="Zloty">Zloty</option>
                                <option value="Riyal du Qatar">Riyal du Qatar</option><option value="Livre sterling">Livre sterling</option><option value="Rouble russe">Rouble russe</option>
                                <option value="Franc du Rwanda">Franc du Rwanda</option><option value="Dirham marocain">Dirham marocain</option><option value="Livre de Sainte-Hélène">Livre de Sainte-Hélène</option><option value="Dollar de Salomon">Dollar de Salomon</option>
                                <option value="Tala">Tala</option><option value="Dobra">Dobra</option><option value="Dinar serbe">Dinar serbe</option>
                                <option value="Roupie des Seychelles">Roupie des Seychelles</option><option value="Leone">Leone</option><option value="Dollar de Singapour">Dollar de Singapour</option>
                                <option value="Shilling de Somalie">Shilling de Somalie</option><option value="Livre soudanaise">Livre soudanaise</option><option value="Roupie de Sri Lanka">Roupie de Sri Lanka</option>
                                <option value="Couronne suédoise">Couronne suédoise</option><option value="Dollar de Surinam">Dollar de Surinam</option><option value="Lilangeni">Lilangeni</option>
                                <option value="Livre syrienne">Livre syrienne</option><option value="Somoni">Somoni</option><option value="Nouveau dollar de Taïwan">Nouveau dollar de Taïwan</option>
                                <option value="Shilling de Tanzanie">Shilling de Tanzanie</option><option value="Couronne tchèque">Couronne tchèque</option><option value="Baht">Baht</option><option value="Pa'anga">Pa'anga</option>
                                <option value="Dollar de la Trinité et de Tobago">Dollar de la Trinité et de Tobago</option><option value="Dinar tunisien">Dinar tunisien</option><option value="Manat">Manat</option><option value="Hryvnia">Hryvnia</option>
                                <option value="Peso uruguayen">Peso uruguayen</option><option value="Vatu">Vatu</option><option value="Bolivar Fuerte">Bolivar Fuerte</option>
                                <option value="Dong">Dong</option><option value="Riyal du Yémen">Riyal du Yémen</option><option value="Kwacha">Kwacha</option><option value="Dollar du Zimbabwe">Dollar du Zimbabwe</option>
                            </select>
                        </div>
                       
                        <div className="form-group">
                        <label htmlFor="stock_initial">Stock initial</label>
                            <input 
                                type="number" 
                                name="stock_initial"
                                multiple
                                {...register(
                                    "stock_initial", 
                                    { required: "Stock initial requis."}
                                )} aria-invalid={errors.stock_initial? "true" : "false"}
                            />
                            {errors.stock_initial && (
                                <p role="alert" className="text-error">
                                    {errors.stock_initial?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <input 
                                type="file" 
                                name="logo"
                                multiple 
                                {...register(
                                    "logo", 
                                    { required: "logo requis."}
                                )} aria-invalid={errors.logo? "true" : "false"}
                            />
                            {errors.logo && (
                                <p role="alert" className="text-error">
                                    {errors.logo?.message}
                                </p>
                            )}
                        </div>

                        <div className="form-group">
                            <label htmlFor="details">Description</label>
                            <textarea
                                value={""} 
                                name="details"
                                placeholder="Saisisser la description detaillee ..." 
                                {...register(
                                    "details", 
                                    { required: "Description detaillee requise."}
                                )} aria-invalid={errors.details? "true" : "false"}
                            />
                            {errors.details && (
                                <p role="alert" className="text-error">
                                    {errors.details?.message}
                                </p>
                            )}
                        </div>

                        <input type="hidden" name="id" />

                        <input type="hidden" name="saisi_par" />

                        <input type="hidden" name="id_store" /><br/>

                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Ajouter" />
                    </form>
                </div>
                <div className="table-container">
                    <table className="tab-produit">
                        <thead>
                            <tr>
                                <th>Nº ordre</th>
                                <th>Designation</th>
                                <th>Prix unitaire</th>
                                <th>Niveau alerte</th>
                                <th>Seuil approv.</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
        </div>
    )
}
export default Produit;