import React from 'react';
import Card from '@/admin/components/Card';
import LoginForm from '@/admin/features/auth/components/LoginForm';

const Login = () => {
    return (
        <div className="container mx-auto my-auto py-8">
            <Card additionalClasses="max-w-md mx-auto shadow-lg">
                <h1 className="text-2xl font-bold py-5 mb-6 text-center ">Zaloguj się</h1>
                <LoginForm />
            </Card>
        </div>
    );
};

export default Login;
