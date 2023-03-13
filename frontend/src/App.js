import { Routes, Route, Navigate } from 'react-router-dom';
import Aberto from './Pages/Chamados/Aberto';
import Andamento from './Pages/Chamados/Andamento';
import Home from './Pages/Home';
import Login from './Pages/Login';
import Cadastrar from './Pages/Solicitantes/Cadastrar';
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
          exact
          element={
            <>
              <Home />
            </>
          }>
        </Route>
        <Route
          path="/solicitantes/cadastrar"
          exact
          element={
            <>
              <Cadastrar />
            </>
          }>
        </Route>
        <Route
          path="/solicitantes/esqueceu"
          exact
          element={
            <>
              <Esqueceu />
            </>
          }>
        </Route>
        <Route
          path="/chamados/aberto"
          exact
          element={
            <>
              <Aberto />
            </>
          }>
        </Route>
        <Route
          path="/chamados/em-andamento"
          exact
          element={
            <>
              <Andamento />
            </>
          }>
        </Route>
        <Route
          path="/chamados/finalizado"
          exact
          element={
            <>
              <Aberto />
            </>
          }>
        </Route>
      </Routes>
    </>
  );
}

export default App;
