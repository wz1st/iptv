.class Lcom/airbnb/lottie/u$a$2;
.super Ljava/lang/Object;

# interfaces
.implements Lcom/airbnb/lottie/n$a;


# annotations
.annotation system Ldalvik/annotation/EnclosingClass;
    value = Lcom/airbnb/lottie/u$a;
.end annotation

.annotation system Ldalvik/annotation/InnerClass;
    accessFlags = 0x0
    name = null
.end annotation

.annotation system Ldalvik/annotation/Signature;
    value = {
        "Ljava/lang/Object;",
        "Lcom/airbnb/lottie/n$a",
        "<",
        "Landroid/graphics/PointF;",
        ">;"
    }
.end annotation


# instance fields
.field final synthetic a:Lcom/airbnb/lottie/u$a;


# direct methods
.method constructor <init>(Lcom/airbnb/lottie/u$a;)V
    .locals 0

    iput-object p1, p0, Lcom/airbnb/lottie/u$a$2;->a:Lcom/airbnb/lottie/u$a;

    invoke-direct {p0}, Ljava/lang/Object;-><init>()V

    return-void
.end method


# virtual methods
.method public a(Landroid/graphics/PointF;)V
    .locals 1

    iget-object v0, p0, Lcom/airbnb/lottie/u$a$2;->a:Lcom/airbnb/lottie/u$a;

    invoke-virtual {v0}, Lcom/airbnb/lottie/u$a;->invalidateSelf()V

    return-void
.end method

.method public bridge synthetic a(Ljava/lang/Object;)V
    .locals 0

    check-cast p1, Landroid/graphics/PointF;

    invoke-virtual {p0, p1}, Lcom/airbnb/lottie/u$a$2;->a(Landroid/graphics/PointF;)V

    return-void
.end method
