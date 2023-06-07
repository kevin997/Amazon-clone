import React from "react";
import { IMAGES } from "../../configurations/images";

function Home() {
    return (
        <div className="header">
            <img className="hide-bg" src={IMAGES.amazonLogo} alt="logo" />
            <h1>Welcome to amazon app clone</h1>
        </div>
    );
}

export default Home;
