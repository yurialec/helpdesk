import { Routes, Route, Navigate } from 'react-router-dom';
import Login from './Pages/Login';

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
      </Routes>
    </>
  );
}

export default App;
