import React, { useEffect, useState } from 'react';
import ChevronIcon from '@/images/icons/chevron.svg';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';

interface FormSectionProps {
    children: React.ReactNode;
    title: string;
    forceOpen?: boolean;
    useDefaultGap?: boolean;
    contentContainerClasses?: string;
}

const FormSection: React.FC<FormSectionProps> = ({
    children,
    title,
    forceOpen,
    useDefaultGap = true,
    contentContainerClasses = '',
}) => {
    const [showContent, setShowContent] = useState<boolean>(true);

    useEffect(() => {
        if (forceOpen !== undefined && !showContent) {
            setShowContent(forceOpen);
        }
    }, [forceOpen]);

    return (
        <section className="border border-gray-100 p-4 rounded-2xl mt-[2rem] bg-white">
            <div
                className="pb-4 border-b border-gray-100 flex gap-3 items-center cursor-pointer"
                onClick={() => setShowContent((prevState) => !prevState)}
            >
                <ChevronIcon className={`h-[16px] w-[16px] ${showContent ? 'rotate-180' : ''} `} />
                <Heading level={HeadingLevel.H3}>{title}</Heading>
            </div>
            <div
                className={`py-4 flex flex-col ${useDefaultGap ? 'gap-[2rem]' : ''} ${showContent ? '' : 'hidden'} ${contentContainerClasses} `}
            >
                {children}
            </div>
        </section>
    );
};

export default FormSection;
