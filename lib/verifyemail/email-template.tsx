import * as React from "react";

interface VerificationEmailTemplateProps {
  firstName: string;
  verificationToken: string;
  email: string;
}

export const VerificationEmailTemplate: React.FC<
  Readonly<VerificationEmailTemplateProps>
> = ({ firstName, verificationToken, email }) => (
  <div
    style={{
      fontFamily: "Arial, sans-serif",
      maxWidth: "600px",
      margin: "0 auto",
      backgroundColor: "#0f172a", // Dark background
      color: "#e2e8f0", // Light text
    }}
  >
    {/* Header */}
    <div
      style={{
        backgroundColor: "oklch(77.4 0.26 295.7)", // Accent color
        padding: "40px 20px",
        textAlign: "center" as const,
      }}
    >
      <h1
        style={{
          color: "#0f172a",
          fontSize: "28px",
          fontWeight: "bold",
          margin: "0 0 10px 0",
        }}
      >
        FreeFlow
      </h1>
      <p
        style={{
          color: "#1e293b",
          fontSize: "16px",
          margin: "0",
        }}
      >
        Your freelance business, simplified.
      </p>
    </div>

    {/* Main Content */}
    <div
      style={{
        padding: "40px 20px",
      }}
    >
      <h2
        style={{
          fontSize: "24px",
          fontWeight: "bold",
          marginBottom: "20px",
          color: "#f1f5f9",
        }}
      >
        Welcome to FreeFlow, {firstName}! 👋
      </h2>

      <p
        style={{
          fontSize: "16px",
          lineHeight: "1.6",
          marginBottom: "20px",
          color: "#cbd5e1",
        }}
      >
        Thanks for signing up! You&apos;re just one step away from accessing
        your all-in-one freelancer platform where you can showcase your work,
        manage clients, and get paid—all in one place.
      </p>

      <p
        style={{
          fontSize: "16px",
          lineHeight: "1.6",
          marginBottom: "30px",
          color: "#cbd5e1",
        }}
      >
        Please verify your email address by clicking the button below:
      </p>

      {/* Verification Button */}
      <div style={{ textAlign: "center" as const, marginBottom: "30px" }}>
        <a
          href={`https://freeflowapp.vercel.app/api/auth/verifyemail?token=${verificationToken}&email=${email}`}
          style={{
            display: "inline-block",
            backgroundColor: "oklch(77.4 0.26 295.7)",
            color: "#0f172a",
            padding: "15px 30px",
            textDecoration: "none",
            borderRadius: "8px",
            fontSize: "16px",
            fontWeight: "bold",
            transition: "background-color 0.3s",
          }}
        >
          Verify Your Email
        </a>
      </div>

      <p
        style={{
          fontSize: "14px",
          color: "#94a3b8",
          marginBottom: "20px",
          textAlign: "center" as const,
        }}
      >
        This verification link will expire in 15 min.
      </p>

      {/* Alternative Link */}
      <div
        style={{
          backgroundColor: "#1e293b",
          padding: "20px",
          borderRadius: "8px",
          marginBottom: "30px",
        }}
      >
        <p
          style={{
            fontSize: "14px",
            color: "#cbd5e1",
            marginBottom: "10px",
          }}
        >
          If the button doesn&apos;t work, copy and paste this link into your
          browser:
        </p>
        <p
          style={{
            fontSize: "14px",
            color: "oklch(77.4 0.26 295.7)",
            wordBreak: "break-all" as const,
            margin: "0",
          }}
        >
          {`https://freeflowapp.vercel.app/api/auth/verifyemail?token=${verificationToken}&email=${email}`}
        </p>
      </div>

      {/* What&apos;s Next */}
      <div style={{ marginBottom: "30px" }}>
        <h3
          style={{
            fontSize: "18px",
            fontWeight: "bold",
            marginBottom: "15px",
            color: "#f1f5f9",
          }}
        >
          What&apos;s next?
        </h3>
        <ul
          style={{
            paddingLeft: "20px",
            color: "#cbd5e1",
          }}
        >
          <li style={{ marginBottom: "8px" }}>
            Create your stunning portfolio
          </li>
          <li style={{ marginBottom: "8px" }}>Set up your first client</li>
          <li style={{ marginBottom: "8px" }}>Start tracking your time</li>
          <li style={{ marginBottom: "8px" }}>
            Send your first professional invoice
          </li>
        </ul>
      </div>

      <p
        style={{
          fontSize: "16px",
          lineHeight: "1.6",
          color: "#cbd5e1",
        }}
      >
        If you didn&apos;t create an account with FreeFlow, you can safely
        ignore this email.
      </p>
    </div>

    {/* Footer */}
    <div
      style={{
        backgroundColor: "#1e293b",
        padding: "30px 20px",
        textAlign: "center" as const,
        borderTop: "1px solid #334155",
      }}
    >
      <p
        style={{
          fontSize: "14px",
          color: "#94a3b8",
          marginBottom: "10px",
        }}
      >
        Need help? Contact us at{" "}
        <a
          href="mailto:support@freeflow.com"
          style={{ color: "oklch(77.4 0.26 295.7)" }}
        >
          support@freeflow.com
        </a>
      </p>
      <p
        style={{
          fontSize: "12px",
          color: "#64748b",
          margin: "0",
        }}
      >
        © 2025 FreeFlow. All rights reserved.
      </p>
    </div>
  </div>
);
