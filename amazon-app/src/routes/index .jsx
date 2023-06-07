import {createBrowserRouter} from "react-router-dom"
import Home from "../pages/landing/Home"
import SignUp from "../pages/authentication/SignUp"
import Login from "../pages/authentication/Login";

const router = createBrowserRouter([
    {
        path: "/",
        element: <Home/>
    },
    {
        path:"/admin/sign-up",
        element: <SignUp/>
    },
    {
        path:"/admin/sign-in",
        element: <Login/>
    }
])

export default router;