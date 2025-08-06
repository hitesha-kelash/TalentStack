import FAQs from "@/components/Landing/FAQs";
import Footer from "@/components/Landing/Footer";
import { Hero } from "@/components/Landing/Hero";
import PricingTeaser from "@/components/Landing/pricing";
import Showcase from "@/components/Landing/Showcase";
import Navbar from "@/components/ui/Navbar";

export default function Home() {
  return (
    <div className="">
      <Navbar />
      <Hero />
      <Showcase />
      <PricingTeaser />
      <FAQs />
      <Footer />
    </div>
  );
}
