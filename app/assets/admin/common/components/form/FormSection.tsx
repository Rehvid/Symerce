import React, { useEffect, useState, useRef } from 'react';
import ChevronIcon from '@/images/icons/chevron.svg';
import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import { AnimatePresence, motion } from 'framer-motion';

interface FormSectionProps {
    children: React.ReactNode;
    title: string;
    forceOpen?: boolean;
    useDefaultGap?: boolean;
    useToggleContent?: boolean;
    contentContainerClasses?: string;
}

const FormSection: React.FC<FormSectionProps> = ({
    children,
    title,
    forceOpen,
    useToggleContent = true,
    useDefaultGap = true,
    contentContainerClasses = '',
}) => {
    const [isOpen, setIsOpen] = useState(true);
    const contentRef = useRef<HTMLDivElement>(null);
    const [contentHeight, setContentHeight] = useState<number>(0);

    useEffect(() => {
        if (forceOpen !== undefined) {
            setIsOpen(forceOpen);
        }
    }, [forceOpen]);

    useEffect(() => {
        if (contentRef.current) {
            setContentHeight(contentRef.current.scrollHeight);
        }
    }, [children]);

    return (
        <section className="border border-gray-100 p-4 rounded-2xl mt-[2rem] bg-white">
            {useToggleContent ? (
                <div
                    className="pb-4 border-b border-gray-100 flex gap-3 items-center cursor-pointer select-none"
                    onClick={() => setIsOpen((prev) => !prev)}
                >
                    <ChevronIcon
                        className={`h-[16px] w-[16px] transition-transform duration-300 ${
                            isOpen ? 'rotate-180' : ''
                        }`}
                    />
                    <Heading level={HeadingLevel.H3}>{title}</Heading>
                </div>
            ) : (
                <div className="pb-4 border-b border-gray-100 flex gap-3 items-center">
                    <Heading level={HeadingLevel.H3}>{title}</Heading>
                </div>
            )}

            <AnimatePresence initial={false}>
                <motion.div
                    initial={false}
                    animate={{ height: isOpen ? contentHeight : 0, opacity: isOpen ? 1 : 0 }}
                    transition={{ duration: 0.3, ease: 'easeInOut' }}
                    style={{ overflow: 'hidden' }}
                >
                    <div
                        ref={contentRef}
                        className={`py-4 flex flex-col ${
                            useDefaultGap ? 'gap-[2rem]' : ''
                        } ${contentContainerClasses}`}
                    >
                        {children}
                    </div>
                </motion.div>
            </AnimatePresence>
        </section>
    );
};

export default FormSection;
