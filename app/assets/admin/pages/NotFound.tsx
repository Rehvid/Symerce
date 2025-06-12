import React from 'react';
import Button, { ButtonVariant } from '@admin/common/components/Button';
import { useNavigate } from 'react-router-dom';

const NotFound: React.FC = () => {
    const navigate = useNavigate();

    return (
        <div className="flex flex-col min-h-screen justify-center items-center gap-6">
            <h1 className="text-7xl font-medium uppercase mb-4">404</h1>
            <div className="text-3xl text-gray-700 mb-4">
                Przepraszamy, ale strona, której szukasz, nie istnieje lub została przeniesiona.
            </div>
            <Button
                onClick={() => navigate('/admin/dashboard')}
                variant={ButtonVariant.Primary}
                additionalClasses="py-3 px-5 uppercase"
            >
                Wróć na stronę główną
            </Button>
        </div>
    );
};

export default NotFound;
