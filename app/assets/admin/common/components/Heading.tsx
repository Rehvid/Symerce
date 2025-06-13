import React, { ReactNode } from 'react';

export enum HeadingLevel {
    H1 = 'h1',
    H2 = 'h2',
    H3 = 'h3',
    H4 = 'h4',
    H5 = 'h5',
    H6 = 'h6',
}

interface HeadingProps {
    level?: HeadingLevel;
    children: ReactNode;
    additionalClassNames?: string;
}

const Heading: React.FC<HeadingProps> = ({ level = HeadingLevel.H1, children, additionalClassNames = '' }) => {
    const headingStyles: Record<HeadingLevel, string> = {
        [HeadingLevel.H1]: 'text-xl font-semibold',
        [HeadingLevel.H2]: 'text-lg font-semibold',
        [HeadingLevel.H3]: 'text-base font-medium',
        [HeadingLevel.H4]: 'text-sm font-medium',
        [HeadingLevel.H5]: 'text-xs font-medium uppercase tracking-wide text-gray-600',
        [HeadingLevel.H6]: 'text-xs font-medium text-gray-500 uppercase tracking-wider',
    };

    const HeadingTag = level;

    return <HeadingTag className={`${headingStyles[level]} ${additionalClassNames}`}>{children}</HeadingTag>;
};

export default Heading;
