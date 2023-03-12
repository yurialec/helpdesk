import { Routes, Route, Navigate } from 'react-router-dom';
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
      </Routes>
    </>
  );
}

export default App;
