import {createBrowserRouter} from "react-router-dom";
import Home from "../pages/landing/Home";
import SignUp from "../pages/authentication/SignUp";
import Login from "../pages/authentication/Login";
import Categorie from "../pages/others/categorie";
import PlanVente from "../pages/others/planvente";
import Abonnement from "../pages/others/abonnement";
import Tva from "../pages/others/grid_tva";
import Store from "../pages/others/store";
import Produit from "../pages/others/produit";
import User from "../pages/others/user";

const router = createBrowserRouter([
    {
        path: "/",
        element: <Home/>
    },
    {
        path:"/SignUp",
        element: <SignUp/>
    },
    {
        path:"/Login",
        element: <Login/>
    },
    {
        path:"/Categorie",
        element: <Categorie/>
    },
    {
        path:"/PlanVente",
        element: <PlanVente/>
    },
    {
        path:"/Abonnement",
        element: <Abonnement/>
    },
    {
        path:"/Tva",
        element: <Tva/>
    },
    {
        path:"/Store",
        element: <Store/>
    },
    {
        path:"/Produit",
        element: <Produit/>
    },
    {
        path:"/User",
        element: <User/>
    }
])

export default router;
