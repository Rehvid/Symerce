import AppButton from '@/admin/components/common/AppButton';
import { useNavigate } from 'react-router-dom';
import { useUser } from '@/admin/hooks/useUser';
import { useAuth } from '@/admin/hooks/useAuth';

const NotFound = () => {
    const navigate = useNavigate();

    return (
        <div className="flex flex-col min-h-screen justify-center items-center gap-6">
            <h1 className="text-7xl font-medium uppercase mb-4">404</h1>
            <div className="text-3xl text-gray-700 mb-4">
                Przepraszamy, ale strona, której szukasz, nie istnieje lub została przeniesiona.
            </div>
            <AppButton
                onClick={() => navigate('/admin/dashboard')}
                variant="primary"
                additionalClasses="py-3 px-5 uppercase"
            >
                Wróć na stronę główną
            </AppButton>
        </div>
    );
};

export default NotFound;
