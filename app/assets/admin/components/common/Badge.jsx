const Badge = ({variant = 'info', children}) => {
  const variants = {
    info: 'bg-info text-black',
    success: 'bg-success text-black',
    error: 'bg-error text-black',
    warning: 'bg-warning text-black',
  }

  return (
    <span className={`inline-flex items-center px-2 py-1  text-xs font-medium rounded-lg ${variants[variant]}`}>
      {children}
    </span>
  )
}

export default Badge;
