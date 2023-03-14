import { Routes, Route, Navigate } from 'react-router-dom';
import Aberto from './Pages/Chamados/Aberto';
import Andamento from './Pages/Chamados/Andamento';
import CadastrarChamado from './Pages/Chamados/CadastrarChamado';
import Home from './Pages/Home';
import Login from './Pages/Login';
import CadastrarSolicitante from './Pages/Solicitantes/CadastrarSolicitante';
import DadosSolicitante from './Pages/Solicitantes/DadosSolicitante';
import Esqueceu from './Pages/Solicitantes/Esqueceu';

function App() {
  return (
    <>
      <Routes>
        <Route
          path="/"
          exact
          element={
            <>
              <Login />
            </>
          }>
        </Route>
        <Route
          path="/home"
          element={
            <>
              <Home />
            </>
          }>
        </Route>
        <Route
          path="/solicitantes/cadastrar"
          element={
            <>
              <CadastrarSolicitante />
            </>
          }>
        </Route>
        <Route
          path="/solicitantes/esqueceu"
          element={
            <>
              <Esqueceu />
            </>
          }>
        </Route>
        <Route
          path="/chamados/aberto"
          element={
            <>
              <Aberto />
            </>
          }>
        </Route>
        <Route
          path="/chamados/em-andamento"
          element={
            <>
              <Andamento />
            </>
          }>
        </Route>
        <Route
          path="/chamados/finalizado"
          element={
            <>
              <Aberto />
            </>
          }>
        </Route>
        <Route
          path="/chamados/cadastrar"
          element={
            <>
              <CadastrarChamado />
            </>
          }>
        </Route>
        <Route
          path="/dados-solicitante"
          element={
            <>
              <DadosSolicitante />
            </>
          }>
        </Route>
      </Routes>
    </>
  );
}

export default App;
