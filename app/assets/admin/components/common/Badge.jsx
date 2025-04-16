const Badge = ({variant = 'info', children}) => {
  const variants = {
    info: 'bg-blue-100 text-blue-800',
    success: 'bg-green-100 text-green-800',
    error: 'bg-red-100 text-error-800'
  }

  return (
    <span className={`inline-flex items-center px-2 py-1  text-xs font-medium rounded-lg ${variants[variant]}`}>
      {children}
    </span>
  )
}

export default Badge;
