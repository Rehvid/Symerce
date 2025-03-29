import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import RestApiClient from '../../../shared/api/RestApiClient';
import { createApiConfig } from '../../../shared/api/ApiConfig';
import RegisterForm from './Partials/RegisterForm';
import Card from "@/admin/components/Card";

const RegisterPage = () => {
    const [validationErrors, setValidationErrors] = useState({});
    const navigate = useNavigate();
    const registerConfig = createApiConfig('auth/register', 'POST', true);
    const onSubmit = async values => {
        try {
            const response = await RestApiClient().executeRequest(registerConfig, values);
            const { success, errors } = response;

            if (success) {
                navigate('/admin/login');
            }

            setValidationErrors(errors);
        } catch (e) {
            console.log('Unexpected error:', e);
        }
    };

    return (
        <div className="container mx-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Zarejestruj się</h1>
                <RegisterForm onSubmit={onSubmit} validationErrors={validationErrors} />
            </Card>
        </div>
    );
};

export default RegisterPage;
