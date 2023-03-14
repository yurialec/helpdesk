import * as React from 'react';
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Link from '@mui/material/Link';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Container from '@mui/material/Container';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import NavBar from '../../Components/NavBar';
import Footer from '../../Components/Footer';

const theme = createTheme();

export default function CadastrarChamado() {

    return (
        <>
            <NavBar />
            <ThemeProvider theme={theme}>
                <Container component="main" maxWidth="xs">
                    <CssBaseline />
                    <Box
                        sx={{
                            marginTop: 8,
                            display: 'flex',
                            flexDirection: 'column',
                            alignItems: 'center',
                        }}
                    >
                        <Box component="form" noValidate sx={{ mt: 1 }}>
                            <TextField
                                disabled
                                margin="normal"
                                fullWidth
                                id="nome"
                                label="Nome do Solicitante"
                                name="nome"
                                autoFocus
                            />
                            <TextField
                                disabled
                                margin="normal"
                                fullWidth
                                id="email"
                                label="E-mail do Solicitante"
                                name="email"
                                autoComplete="email"
                                autoFocus
                            />

                            <TextField
                                fullWidth
                                id="descricao_chamado"
                                label="Descrição do chamado"
                                multiline
                                rows={4}
                                maxRows={4}
                            />

                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                sx={{ mt: 3, mb: 2 }}
                                href="/home"
                            >
                                Cadastrar
                            </Button>
                        </Box>
                    </Box>
                </Container>
            </ThemeProvider>
            <Footer />
        </>
    );
}