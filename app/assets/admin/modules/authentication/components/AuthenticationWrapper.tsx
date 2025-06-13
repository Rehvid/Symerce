import { FC, ReactNode } from 'react';
import Card from '@admin/common/components/Card';
import Logo from '@admin/common/components/Logo';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';

interface AuthenticationWrapperProps {
    title: string;
    children: ReactNode;
}

const AuthenticationWrapper: FC<AuthenticationWrapperProps> = ({ title, children }) => {
    return (
        <div className="flex flex-col items-center justify-center min-h-screen p-5 md:p-5">
            <div className="flex flex-col gap-2 justify-center">
                <Logo classesName="h-32" />
                <Heading level={HeadingLevel.H1} additionalClassNames="text-center py-2 mb-5 text-gray-500">
                    {title}
                </Heading>
            </div>
            <Card additionalClasses="w-full md:max-w-lg mx-auto shadow-xl">{children}</Card>
        </div>
    );
};

export default AuthenticationWrapper;
