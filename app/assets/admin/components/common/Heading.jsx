const Heading = ({level = 'h1', children, additionalClassNames = ''}) => {
  const headingStyles = {
    h1: 'text-4xl lg:text-5xl font-bold leading-tight',
    h2: 'text-3xl lg:text-4xl font-semibold leading-snug',
    h3: 'text-2xl font-semibold leading-snug',
    h4: 'text-xl font-medium leading-snug',
    h5: 'text-lg font-medium leading-normal',
    h6: 'text-base font-medium leading-normal uppercase'
  }
  const HeadingTag = level

  return <HeadingTag className={`${headingStyles[level]} ${additionalClassNames} `}>{children}</HeadingTag>
}

export default Heading;
