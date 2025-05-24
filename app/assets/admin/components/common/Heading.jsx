const Heading = ({ level = 'h1', children, additionalClassNames = '' }) => {
    const headingStyles = {
        h1: 'text-xl font-semibold',
        h2: 'text-lg font-semibold',
        h3: 'text-base font-medium',
        h4: 'text-sm font-medium',
        h5: 'text-xs font-medium uppercase tracking-wide text-gray-600',
        h6: 'text-xs font-medium text-gray-500 uppercase tracking-wider',
    };
    const HeadingTag = level;

    return <HeadingTag className={`${headingStyles[level]} ${additionalClassNames} `}>{children}</HeadingTag>;
};

export default Heading;
