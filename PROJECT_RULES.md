# Project Rules & Development Guidelines
## YB Dato' Zunita Begum Website Project

### 🎯 Project Overview
**Project**: YB Dato' Zunita Begum Official Website & CMS  
**Version**: 1.0  
**Last Updated**: January 2025  
**Status**: Active  

---

## 📋 Development Standards

### 1. Code Standards

#### 1.1 PHP/Laravel Standards
- **Framework**: Laravel 11 (PHP 8.2+)
- **Coding Style**: PSR-12 standards
- **Documentation**: PHPDoc for all classes and methods
- **Naming Conventions**:
  - Classes: PascalCase (e.g., `ContributionController`)
  - Methods: camelCase (e.g., `getContributionStats`)
  - Variables: camelCase (e.g., `$recipientName`)
  - Constants: UPPER_SNAKE_CASE (e.g., `MAX_FILE_SIZE`)

#### 1.2 Database Standards
- **Naming**: snake_case for tables and columns
- **Migrations**: Descriptive names with timestamps
- **Foreign Keys**: `{table}_id` format
- **Indexes**: Add indexes for frequently queried columns
- **Soft Deletes**: Use for all user-generated content

#### 1.3 Frontend Standards
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Vanilla JS or Alpine.js (no heavy frameworks)
- **Responsive Design**: Mobile-first approach
- **Accessibility**: WCAG 2.1 AA compliance

### 2. Security Rules

#### 2.1 Data Protection
- **Encryption**: All sensitive data must be encrypted at rest
- **PDPA Compliance**: Malaysian Personal Data Protection Act
- **Recipient Privacy**: Public display must be anonymized
- **Access Control**: Role-based permissions for all features

#### 2.2 Input Validation
- **Server-side**: All inputs validated on server
- **Client-side**: Additional validation for UX
- **SQL Injection**: Use Eloquent ORM, no raw queries
- **XSS Protection**: Escape all user-generated content

#### 2.3 Authentication & Authorization
- **Password Policy**: Minimum 8 characters, complexity required
- **Session Management**: Secure session handling
- **CSRF Protection**: All forms must include CSRF tokens
- **Rate Limiting**: Implement on sensitive endpoints

### 3. Performance Rules

#### 3.1 Database Optimization
- **Query Optimization**: Use eager loading, avoid N+1 queries
- **Caching**: Redis for frequently accessed data
- **Indexing**: Proper indexes on search columns
- **Pagination**: Implement for large datasets

#### 3.2 Frontend Performance
- **Image Optimization**: Compress and resize images
- **Lazy Loading**: Implement for images and content
- **Minification**: CSS and JS files minified
- **CDN**: Use for static assets

#### 3.3 Mobile Performance
- **Load Time**: < 3 seconds on mobile networks
- **Touch Targets**: Minimum 44px for buttons
- **Offline Capability**: PWA features for critical functions

### 4. Content Management Rules

#### 4.1 Content Standards
- **Language**: Malay primary, English secondary
- **Tone**: Professional but approachable
- **Accuracy**: All information must be verified
- **Updates**: Regular content updates required

#### 4.2 Media Management
- **File Types**: JPG, PNG, PDF, DOCX only
- **Size Limits**: Images < 2MB, Documents < 10MB
- **Alt Text**: Required for all images
- **Organization**: Proper folder structure

#### 4.3 Approval Process
- **Content Review**: All content reviewed before publishing
- **Version Control**: Track all content changes
- **Backup**: Regular content backups
- **Rollback**: Ability to revert changes

### 5. Development Workflow

#### 5.1 Git Workflow
- **Branch Naming**: `feature/task-description` or `bugfix/issue-description`
- **Commits**: Descriptive commit messages
- **Pull Requests**: Required for all changes
- **Code Review**: Mandatory before merge

#### 5.2 Testing Requirements
- **Unit Tests**: 80% code coverage minimum
- **Integration Tests**: Critical user flows
- **Security Tests**: Regular security audits
- **Performance Tests**: Load testing before deployment

#### 5.3 Deployment Rules
- **Staging Environment**: Test all changes before production
- **Database Migrations**: Always backup before running
- **Rollback Plan**: Ability to quickly revert changes
- **Monitoring**: Set up alerts for critical issues

### 6. User Experience Rules

#### 6.1 Accessibility
- **Screen Readers**: Full compatibility
- **Keyboard Navigation**: All features accessible
- **Color Contrast**: WCAG AA standards
- **Font Size**: Minimum 16px for body text

#### 6.2 Mobile Experience
- **Responsive Design**: Works on all screen sizes
- **Touch Friendly**: Large touch targets
- **Fast Loading**: Optimized for mobile networks
- **Offline Support**: Critical functions work offline

#### 6.3 User Interface
- **Consistency**: Uniform design language
- **Intuitive**: Easy to understand and use
- **Feedback**: Clear success/error messages
- **Progress Indicators**: For long operations

### 7. Data Management Rules

#### 7.1 Data Entry
- **Validation**: Real-time validation with clear messages
- **Auto-save**: Save progress automatically
- **Error Prevention**: Prevent common mistakes
- **Bulk Operations**: Support for multiple entries

#### 7.2 Data Privacy
- **Anonymization**: Public data must be anonymized
- **Consent**: Track user consent for data usage
- **Retention**: Configurable data retention policies
- **Deletion**: Right to be forgotten implementation

#### 7.3 Data Integrity
- **Validation**: Multiple layers of data validation
- **Audit Trail**: Track all data changes
- **Backup**: Regular automated backups
- **Recovery**: Quick data recovery procedures

### 8. Communication Rules

#### 8.1 Stakeholder Communication
- **Regular Updates**: Weekly progress reports
- **Issue Escalation**: Clear escalation procedures
- **Change Management**: Communicate all changes
- **Documentation**: Keep all documentation updated

#### 8.2 Team Communication
- **Daily Standups**: Brief daily updates
- **Code Reviews**: Constructive feedback
- **Knowledge Sharing**: Document learnings
- **Collaboration**: Pair programming when needed

### 9. Quality Assurance Rules

#### 9.1 Code Quality
- **Static Analysis**: Use PHPStan or similar tools
- **Code Review**: All code reviewed by peers
- **Documentation**: Keep code well-documented
- **Refactoring**: Regular code cleanup

#### 9.2 Testing Strategy
- **Automated Testing**: CI/CD pipeline
- **Manual Testing**: User acceptance testing
- **Security Testing**: Regular security scans
- **Performance Testing**: Load and stress testing

#### 9.3 Bug Management
- **Issue Tracking**: Use project management tools
- **Priority Levels**: Clear priority classification
- **Reproduction Steps**: Detailed bug reports
- **Fix Verification**: Confirm fixes work

### 10. Maintenance Rules

#### 10.1 Regular Maintenance
- **Security Updates**: Apply patches promptly
- **Performance Monitoring**: Track system performance
- **Backup Verification**: Test backup restoration
- **Log Analysis**: Monitor system logs

#### 10.2 User Support
- **Help Documentation**: Comprehensive user guides
- **Training Materials**: Video tutorials and guides
- **Support Channels**: Multiple support options
- **Response Times**: Define SLA for support

#### 10.3 System Monitoring
- **Uptime Monitoring**: 24/7 system monitoring
- **Error Tracking**: Monitor and alert on errors
- **Performance Metrics**: Track key performance indicators
- **User Analytics**: Monitor user behavior

---

## 🚨 Critical Rules (Must Follow)

### 1. Security First
- **NEVER** commit sensitive data to version control
- **ALWAYS** validate and sanitize user input
- **MUST** use HTTPS in production
- **REQUIRED** to log security events

### 2. Data Privacy
- **NEVER** expose personal data publicly
- **ALWAYS** anonymize data for public display
- **MUST** get consent for data collection
- **REQUIRED** to respect data deletion requests

### 3. Performance
- **NEVER** deploy without performance testing
- **ALWAYS** optimize database queries
- **MUST** implement caching for frequently accessed data
- **REQUIRED** to monitor page load times

### 4. Quality
- **NEVER** deploy untested code
- **ALWAYS** write tests for new features
- **MUST** review code before merging
- **REQUIRED** to document all changes

---

## 📊 Compliance Checklist

### Development Phase
- [ ] Code follows PSR-12 standards
- [ ] All inputs validated and sanitized
- [ ] Database queries optimized
- [ ] Tests written and passing
- [ ] Documentation updated
- [ ] Security review completed

### Deployment Phase
- [ ] Staging environment tested
- [ ] Performance testing completed
- [ ] Security scan passed
- [ ] Backup procedures verified
- [ ] Rollback plan prepared
- [ ] Monitoring configured

### Post-Deployment
- [ ] System monitoring active
- [ ] User training completed
- [ ] Support procedures in place
- [ ] Maintenance schedule created
- [ ] Performance metrics tracked
- [ ] User feedback collected

---

## 🔄 Review and Updates

### Regular Reviews
- **Weekly**: Review progress against rules
- **Monthly**: Update rules based on learnings
- **Quarterly**: Comprehensive rule review
- **Annually**: Major rule revision

### Rule Updates
- **Process**: Submit changes for review
- **Approval**: Stakeholder approval required
- **Communication**: Notify all team members
- **Documentation**: Update all related documents

---

**Document Version**: 1.0  
**Next Review**: February 2025  
**Approved By**: Project Stakeholders  
**Maintained By**: Development Team
