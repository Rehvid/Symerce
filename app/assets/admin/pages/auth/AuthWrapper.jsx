import Card from '@/admin/components/Card';
import Logo from '@/admin/components/Logo';
import Heading from '@/admin/components/common/Heading';

const AuthWrapper = ({ title, children }) => (
    <div className="flex flex-col items-center justify-center min-h-screen p-5 md:p-5">
        <Card additionalClasses="w-full md:max-w-xl mx-auto shadow-xl">
            <div className="flex justify-center mb-5">
                <Logo classesName="h-24" />
            </div>

            <Heading level="h2" additionalClassNames="text-center py-2 mb-5">
                {title}
            </Heading>
            {children}
        </Card>
    </div>
);

export default AuthWrapper;
