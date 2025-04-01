import React, {useState} from 'react';
import {useNavigate} from 'react-router-dom';
import LoginForm from './Partials/LoginForm';
import { createApiConfig } from '@/shared/api/ApiConfig';
import {useAuth} from "@/admin/hooks/useAuth";
import {useApi} from "@/admin/hooks/useApi";
import Card from "@/admin/components/Card";
import Alert from "@/admin/components/Alert";


const LoginPage = () => {
    const [errorMessage, setErrorMessage] = useState(null);
    const navigate = useNavigate();
    const { login } = useAuth();
    const { executeRequest } = useApi();
    const apiConfig = createApiConfig('login_check', 'POST', false);

    const onSubmit = async values => {
        try {
            const result = await executeRequest(apiConfig, values);
            const { data, errors } = result;

            const isEmpty = Object.keys(errors).length === 0;

            if (isEmpty && data) {
                login(data);
                navigate('/admin/dashboard', {replace: true});
            }

            if (!isEmpty) {
               setErrorMessage(errors.message);
            }
        } catch (e) {
            console.error('Unexpected error', e.message);
        }
    };

    return (
        <div className="container mx-auto my-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Zaloguj się</h1>
                {errorMessage && (
                    <Alert variant="error" message={errorMessage} />
                )}
                <LoginForm onSubmit={onSubmit} />
            </Card>
        </div>
    );
};

export default LoginPage;
