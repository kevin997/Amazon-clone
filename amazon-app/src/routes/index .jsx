import {createBrowserRouter} from "react-router-dom"
import Home from "../pages/landing/Home"
import SignUp from "../pages/authentication/SignUp"

const router = createBrowserRouter([
    {
        path: "/",
        element: <Home/>
    },
    {
        path:"/admin/signup",
        element: <SignUp/>
    }
])

export default router;