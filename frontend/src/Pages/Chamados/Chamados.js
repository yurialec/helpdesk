import * as React from 'react';
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import Button from '@mui/material/Button';
import { useState } from "react";
import { Link } from 'react-router-dom';

export default function Chamados() {

    return (
        <div className='mt-5 ml-5 mr-5'>
            <h1 className='mt-5 ml-5 mr-5 text-3xl'>Meus Chamados</h1>
            <div className='mt-5 ml-5 mr-5 flex flex-row'>
                <div className='mt-5 ml-5 mr-5'>
                    <Card sx={{ width: 250 }}>
                        <CardContent>
                            Aberto
                        </CardContent>
                        <CardActions>
                            <Button size="small">
                                <Link to={"/chamados/aberto"}>
                                    Ver Todos
                                </Link>
                            </Button>
                        </CardActions>
                    </Card>
                </div>
                <div className='mt-5 ml-5 mr-5'>
                    <Card sx={{ width: 250 }}>
                        <CardContent>
                            Em Andamento
                        </CardContent>
                        <CardActions>
                            <Button size="small">
                                <Link to={"/chamados/em-andamento"}>
                                    Ver Todos
                                </Link>
                            </Button>
                        </CardActions>
                    </Card>
                </div>
                <div className='mt-5 ml-5 mr-5'>
                    <Card sx={{ width: 250 }}>
                        <CardContent>
                            Finalizado
                        </CardContent>
                        <CardActions>
                            <Button size="small">
                                <Link to={"/chamados/finalizado"}>
                                    Ver Todos
                                </Link>
                            </Button>
                        </CardActions>
                    </Card>
                </div>
            </div>
        </div>

    );
}