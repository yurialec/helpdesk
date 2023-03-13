import React from "react";
import Footer from "../Components/Footer";
import NavBar from "../Components/NavBar";
import Chamados from "./Chamados/Chamados";

export default function Home() {
    return (
        <>
            <NavBar />
            <Chamados />
            <Footer />
        </>
    );
}