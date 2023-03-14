import * as React from 'react';

import LinkedInIcon from '@mui/icons-material/LinkedIn';
import GitHubIcon from '@mui/icons-material/GitHub';
import { Link } from 'react-router-dom';

import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';

export default function Footer() {

    const [open, setOpen] = React.useState(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    return (
        <footer className="py-5 text-center">
            <ul className="flex flex-row space-x-4 p-2 text-xs items-center justify-center text-gray-400">
                <li className="curors-pointer">
                    <a href="https://www.linkedin.com/in/yuri-alec-3976b227/">
                        <LinkedInIcon />
                    </a>
                </li>
                <li className="curors-pointer">
                    <a href="https://github.com/yurialec">
                        <GitHubIcon />
                    </a>
                </li>
                <li className="curors-pointer">
                    <a href='#' onClick={handleClickOpen}>
                        Sobre
                    </a>
                    <Dialog
                        open={open}
                        onClose={handleClose}
                        aria-labelledby="alert-dialog-title"
                        aria-describedby="alert-dialog-description"
                    >
                        <DialogContent>
                            <DialogContentText id="alert-dialog-description">
                                Sistema de abertura de chamados técnico.
                                Não se esqueça de avaliar meu repositório.
                            </DialogContentText>
                        </DialogContent>

                    </Dialog>
                </li>
            </ul>
        </footer >
    );
}