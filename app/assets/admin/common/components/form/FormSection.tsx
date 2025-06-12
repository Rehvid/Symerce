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
    const [contentHeight, setContentHeight] = useState<number | string>(0);

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

    useEffect(() => {
        if (isOpen) {
            setContentHeight('auto');
        } else if (contentRef.current) {
            setContentHeight(0);
        }
    }, [isOpen]);

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

            {useToggleContent ? (
                <AnimatePresence initial={false}>
                    {isOpen && (
                        <motion.div
                            initial={{ height: 0, opacity: 0 }}
                            animate={{ height: contentHeight === 'auto' ? 'auto' : contentHeight, opacity: 1 }}
                            exit={{ height: 0, opacity: 0 }}
                            transition={{ duration: 0.35, ease: 'easeInOut' }}
                            style={{
                                overflow: 'hidden'
                            }}
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
                    )}
                </AnimatePresence>
            ) : (
                <div
                    className={`py-4 flex flex-col ${
                        useDefaultGap ? 'gap-[2rem]' : ''
                    } ${contentContainerClasses}`}
                >
                    {children}
                </div>
            )}
        </section>
    );
};

export default FormSection;
